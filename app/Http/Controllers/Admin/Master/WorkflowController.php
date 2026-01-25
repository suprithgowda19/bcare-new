<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Designation;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $workflows = Workflow::with(['category', 'subcategory'])
            ->withCount('steps')
            ->latest()
            ->get();

        return view('admin.master.workflows.index', compact('workflows'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.master.workflows.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'category_id'            => 'required|exists:categories,id',
            'subcategory_id'         => 'nullable|exists:sub_categories,id',
            'steps'                  => 'required|array|min:1',
            'steps.*.designation_id' => 'required|exists:designations,id',
            'steps.*.sla_hours'      => 'required|integer|min:1',
        ]);

        // Prevent duplicate designation usage
        $designationIds = collect($request->steps)->pluck('designation_id');
        if ($designationIds->count() !== $designationIds->unique()->count()) {
            return back()
                ->with('error', 'Each workflow step must have a unique designation.')
                ->withInput();
        }

        // Prevent duplicate workflow for same category + subcategory
        $exists = Workflow::where('category_id', $request->category_id)
            ->where('subcategory_id', $request->subcategory_id)
            ->exists();

        if ($exists) {
            return back()
                ->with('error', 'A workflow already exists for this category/subcategory.')
                ->withInput();
        }

        try {

            DB::transaction(function () use ($request) {

                $workflow = Workflow::create([
                    'category_id'    => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'is_active'      => true,
                ]);

                foreach ($request->steps as $index => $step) {

                    WorkflowStep::create([
                        'workflow_id'    => $workflow->id,
                        'step_number'    => $index + 1,
                        'designation_id' => $step['designation_id'],
                        'sla_hours'      => $step['sla_hours'],
                    ]);
                }
            });

            return redirect()
                ->route('admin.master.workflows.index')
                ->with('success', 'Workflow created successfully.');

        } catch (\Throwable $e) {

            return back()
                ->with('error', 'Failed to create workflow.')
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(Workflow $workflow)
    {
        // Prevent editing if complaints already exist
        if (Complaint::where('workflow_id', $workflow->id)->exists()) {
            return redirect()
                ->route('admin.master.workflows.index')
                ->with('error', 'Cannot edit workflow already used by complaints.');
        }

        $workflow->load(['steps.designation', 'subcategory']);

        $categories = Category::where('status', 'active')->get();
        $subcategories = SubCategory::where('category_id', $workflow->category_id)->get();

        return view(
            'admin.master.workflows.edit',
            compact('workflow', 'categories', 'subcategories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Workflow $workflow)
    {
        // Prevent update if complaints exist
        if (Complaint::where('workflow_id', $workflow->id)->exists()) {
            return back()
                ->with('error', 'Cannot modify workflow already assigned to complaints.');
        }

        $request->validate([
            'steps'                  => 'required|array|min:1',
            'steps.*.designation_id' => 'required|exists:designations,id',
            'steps.*.sla_hours'      => 'required|integer|min:1',
        ]);

        $designationIds = collect($request->steps)->pluck('designation_id');
        if ($designationIds->count() !== $designationIds->unique()->count()) {
            return back()
                ->with('error', 'Each step must have a unique designation.')
                ->withInput();
        }

        try {

            DB::transaction(function () use ($workflow, $request) {

                $workflow->steps()->delete();

                foreach ($request->steps as $index => $step) {

                    WorkflowStep::create([
                        'workflow_id'    => $workflow->id,
                        'step_number'    => $index + 1,
                        'designation_id' => $step['designation_id'],
                        'sla_hours'      => $step['sla_hours'],
                    ]);
                }
            });

            return redirect()
                ->route('admin.master.workflows.index')
                ->with('success', 'Workflow updated successfully.');

        } catch (\Throwable $e) {

            return back()
                ->with('error', 'Failed to update workflow.')
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(Workflow $workflow)
    {
        if (Complaint::where('workflow_id', $workflow->id)->exists()) {
            return back()
                ->with('error', 'Cannot delete workflow assigned to complaints.');
        }

        try {

            DB::transaction(function () use ($workflow) {
                $workflow->steps()->delete();
                $workflow->delete();
            });

            return redirect()
                ->route('admin.master.workflows.index')
                ->with('success', 'Workflow deleted successfully.');

        } catch (\Throwable $e) {

            return back()
                ->with('error', 'Deletion failed.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(Workflow $workflow)
    {
        $workflow->load([
            'category',
            'subcategory',
            'steps' => function ($query) {
                $query->orderBy('step_number');
            },
            'steps.designation'
        ]);

        return view('admin.master.workflows.show', compact('workflow'));
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX Helpers
    |--------------------------------------------------------------------------
    */

    public function getSubCategories(Request $request)
    {
        return response()->json(
            SubCategory::where('category_id', $request->category_id)
                ->where('status', 'active')
                ->get(['id', 'name'])
        );
    }

    public function getEligibleDesignations(Request $request)
    {
        if (!$request->category_id) {
            return response()->json([]);
        }

        $query = Designation::where('category_id', $request->category_id);

        if ($request->filled('subcategory_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('subcategory_id', $request->subcategory_id)
                  ->orWhereNull('subcategory_id');
            });
        } else {
            $query->whereNull('subcategory_id');
        }

        return response()->json(
            $query->orderBy('name')->get(['id', 'name'])
        );
    }
}
