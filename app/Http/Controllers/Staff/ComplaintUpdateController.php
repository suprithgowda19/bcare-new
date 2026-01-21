<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ComplaintUpdateController extends Controller
{
    use AuthorizesRequests;
    /**
     * List complaints assigned to the logged-in staff's wards
     */
    public function index()
    {
        $staff = Auth::user();

        $complaints = Complaint::whereIn(
            'ward_id',
            $staff->wards()->select('wards.id')
        )
            ->with([
                'category:id,name',
                'subCategory:id,name',
                'user:id,name,phone',
            ])
            ->latest()
            ->paginate(1);

        if ($complaints->isEmpty()) {
            return view('staff.dashboard', [
                'complaints' => $complaints,
            ])->with('error', 'No wards are assigned to your account. Please contact the administrator.');
        }

        return view('staff.dashboard', compact('complaints'));
    }

    /**
     * View a single complaint with update history
     */
    public function show(Complaint $complaint)
    {
        $this->authorize('view', $complaint);

        $complaint->load([
            'category:id,name',
            'subCategory:id,name',
            'user:id,name,phone',
            'updates.staff:id,name',
        ]);

        return view('staff.complaints.show', compact('complaint'));
    }

    /**
     * Show edit form (classification / priority)
     */
    public function edit(Complaint $complaint)
    {
        $this->authorize('update', $complaint);

        $categories = Category::where('status', 'active')
            ->select('id', 'name')
            ->get();

        $subCategories = SubCategory::where('category_id', $complaint->category_id)
            ->select('id', 'name')
            ->get();

        return view(
            'staff.complaints.edit',
            compact('complaint', 'categories', 'subCategories')
        );
    }

    /**
     * Update complaint classification / priority
     */
    public function update(Request $request, Complaint $complaint)
    {
        $this->authorize('update', $complaint);

        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'priority'        => 'required|in:low,medium,high,urgent',
            'status'          => 'required|in:pending,in-progress,resolved,rejected',
        ]);

        DB::transaction(function () use ($request, $complaint) {
            $complaint->update([
                'category_id'     => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'priority'        => $request->priority,
                'status'          => $request->status,
            ]);

            $complaint->updates()->create([
                'staff_id' => auth()->id(),
                'status'   => $request->status,
                'remarks'  => 'Administrative update: classification/priority adjusted.',
            ]);
        });

        return redirect()
            ->route('staff.dashboard')
            ->with('success', 'Complaint updated successfully.');
    }

    /**
     * Update complaint status with remarks and optional images
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $this->authorize('updateStatus', $complaint);

        $request->validate([
            'status'   => 'required|in:pending,in-progress,resolved,rejected',
            'remarks'  => 'required|string|min:5',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($complaint->status === 'resolved') {
            return back()->with('error', 'Resolved complaints cannot be modified.');
        }

        $imagePaths = [];

        if ($request->hasFile('images')) {
            if (count($request->file('images')) > 2) {
                return back()->withErrors([
                    'images' => 'Maximum 2 images allowed.',
                ]);
            }

            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('complaint-updates', 'public');
            }
        }

        DB::transaction(function () use ($request, $complaint, $imagePaths) {
            $complaint->updates()->create([
                'staff_id' => auth()->id(),
                'status'   => $request->status,
                'remarks'  => $request->remarks,
                'images'   => $imagePaths ?: null,
            ]);

            $complaint->update([
                'status' => $request->status,
            ]);
        });

        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * List resolved complaints assigned to the logged-in staff
     */
    public function solvedComplaints()
    {
        $staff = Auth::user();

        $complaints = Complaint::where('status', 'resolved')
            ->whereIn(
                'ward_id',
                $staff->wards()->select('wards.id')
            )
            ->with([
                'category:id,name',
                'subCategory:id,name',
                'user:id,name,phone',
            ])
            ->latest()
            ->paginate(1);

        return view('staff.complaints.solved', compact('complaints'));
    }
}
