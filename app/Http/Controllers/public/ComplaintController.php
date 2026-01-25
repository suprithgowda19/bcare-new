<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Complaint;
use App\Models\ComplaintUpdate;
use App\Services\WorkflowResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// Laravel 12 Compatibility Imports
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ComplaintController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    /**
     * Define middleware for Laravel 12 controllers.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:public'),
        ];
    }

    public function __construct()
    {
        // Manual authorization check is used in methods instead of authorizeResource
        // to prevent compatibility issues with slimmed-down base controllers.
    }

    /*
    |--------------------------------------------------------------------------
    | My Complaints
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $complaints = Complaint::where('user_id', auth()->id())
            ->with(['category', 'subcategory'])
            ->latest()
            ->paginate(10);

        return view('public.complaints.index', compact('complaints'));
    }

    /*
    |--------------------------------------------------------------------------
    | View Single Complaint
    |--------------------------------------------------------------------------
    */

    public function show(Complaint $complaint)
    {
        // Manual Authorization Check
        $this->authorize('view', $complaint);

        $complaint->load([
            'category',
            'subcategory',
            'ward',
            'updates' => function ($query) {
                $query->where('is_public', true)
                      ->latest();
            },
            'updates.actedBy:id,name'
        ]);

        return view('public.complaints.show', compact('complaint'));
    }

    /*
    |--------------------------------------------------------------------------
    | Step 1 – Select Category
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        $categories = Category::where('status', 'active')->get();
        return view('public.complaints.category', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Step 2 – Select Sub Category
    |--------------------------------------------------------------------------
    */

    public function sub_category(Request $request)
    {
        $categoryId = $request->query('category_id');

        if (!$categoryId) {
            return redirect()
                ->route('public.complaints.category')
                ->with('error', 'Category selection is required.');
        }

        $category = Category::findOrFail($categoryId);

        $sub_categories = SubCategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->get();

        return view('public.complaints.sub_category', compact('category', 'sub_categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Step 3 – Complaint Form
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $categoryId = $request->query('category_id');
        $subCategoryId = $request->query('sub_category_id');

        if (!$categoryId || !$subCategoryId) {
            return redirect()
                ->route('public.complaints.category')
                ->with('error', 'Please select category and subcategory.');
        }

        $category = Category::findOrFail($categoryId);
        $subcategory = SubCategory::findOrFail($subCategoryId);

        return view('public.complaints.create', compact('category', 'subcategory'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store Complaint
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'subject'        => 'required|string|max:255',
            'message'        => 'required|string',
            'address'        => 'required|string',
            'priority'       => 'required|in:low,medium,high,urgent',
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'image.*'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'latitude.required'  => 'Location access is required.',
            'longitude.required' => 'Location access is required.',
            'priority.in'        => 'Invalid priority selected.',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;

        // Detect Ward using spatial query
        $ward = DB::table('wards')
            ->select('id', 'name')
            ->where('status', 1)
            ->whereRaw(
                "ST_Contains(geom, ST_PointFromText(CONCAT('POINT(', ?, ' ', ?, ')')))",
                [$lng, $lat]
            )
            ->first();

        if (!$ward) {
            return back()
                ->withInput()
                ->with('error', 'Location not within serviceable ward boundary.');
        }

        $imagePaths = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePaths[] = $file->store('complaints', 'public');
            }
        }

        try {

            DB::transaction(function () use ($request, $ward, $imagePaths, $lat, $lng) {

                $complaint = Complaint::create([
                    'user_id'        => auth()->id(),
                    'ward_id'        => $ward->id,
                    'category_id'    => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'subject'        => $request->subject,
                    'message'        => $request->message,
                    'address'        => $request->address,
                    'priority'       => $request->priority,
                    'latitude'       => $lat,
                    'longitude'      => $lng,
                    'images'         => $imagePaths,
                    'status'         => 'pending',
                ]);

                // Attach workflow (CRITICAL)
                app(WorkflowResolver::class)
                    ->attachWorkflow($complaint);

                // Initial timeline entry
                ComplaintUpdate::create([
                    'complaint_id'     => $complaint->id,
                    'acted_by_user_id' => auth()->id(),
                    'action_type'      => 'comment',
                    'remarks'          => 'Complaint submitted.',
                    'is_public'        => true,
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Complaint creation failed', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while submitting your complaint.');
        }

        return redirect()
            ->route('public.complaints.index')
            ->with('success', "Complaint submitted successfully in Ward: {$ward->name}");
    }

    /*
    |--------------------------------------------------------------------------
    | Report
    |--------------------------------------------------------------------------
    */

    public function report(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {

            $query = Complaint::where('user_id', auth()->id())
                ->with('category:id,name')
                ->latest();

            if ($request->filled('fromdate')) {
                $query->whereDate('created_at', '>=', $request->fromdate);
            }

            if ($request->filled('todate')) {
                $query->whereDate('created_at', '<=', $request->todate);
            }

            $complaints = $query->get();

            $data = $complaints->values()->map(function ($item, $index) {
                return [
                    'sl_no'     => $index + 1,
                    'ticket_id' => 'SP-' . $item->id,
                    'category'  => $item->category->name ?? 'General',
                    'priority'  => ucfirst($item->priority),
                    'status'    => ucfirst(str_replace('_', ' ', $item->status)),
                    'url'       => route('public.complaints.show', $item->id),
                ];
            });

            return response()->json(['data' => $data]);
        }

        return view('public.complaints.report');
    }
}