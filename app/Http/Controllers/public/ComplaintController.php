<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Page 1: My Complaints List
     * Shows the current status of each complaint.
     */
    public function index()
    {
        $complaints = Complaint::where('user_id', auth()->id())
            ->with(['category', 'subcategory'])
            ->latest()
            ->paginate(10); // Changed to paginate for better PWA performance

        return view('public.complaints.index', compact('complaints'));
    }

    /**
     * NEW: View single complaint details and timeline
     * This allows the citizen to see history/remarks from staff.
     */
    public function show(Complaint $complaint)
    {
        // Security: Ensure users can only see their own complaints
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load the complaint with its category and the update history (timeline)
        $complaint->load([
            'category',
            'subcategory',
            'ward',
            'updates' => function ($query) {
                $query->latest(); // Show newest staff updates first
            },
            'updates.staff:id,name' // Load the name of the staff who made the update
        ]);

        return view('public.complaints.show', compact('complaint'));
    }

    /**
     * Step 1: Display Category selection
     */
    public function category()
    {
        $categories = Category::where('status', 'active')->get();
        return view('public.complaints.category', compact('categories'));
    }

    /**
     * Step 2: Display Sub-Category selection
     */
    public function sub_category(Request $request)
    {
        $categoryId = $request->query('category_id');

        if (!$categoryId) {
            return redirect()->route('complaints.category');
        }

        $category = Category::findOrFail($categoryId);
        $sub_categories = SubCategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->get();

        return view('public.complaints.sub_category', compact('category', 'sub_categories'));
    }

    /**
     * Step 3: Display the Final Registration Form
     */
    public function create(Request $request)
    {
        $categoryId = $request->query('category_id');
        $subCategoryId = $request->query('sub_category_id');

        if (!$categoryId || !$subCategoryId) {
            return redirect()->route('complaints.category');
        }

        $category = Category::findOrFail($categoryId);
        $subcategory = SubCategory::findOrFail($subCategoryId);

        return view('public.complaints.create', compact('category', 'subcategory'));
    }

    /**
     * FINAL ACTION: Detect Ward and Store Complaint
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
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;

        // Spatial Ward Detection
        $ward = DB::table('wards')
            ->select('id', 'name')
            ->where('status', 1)
            ->whereRaw("ST_Contains(geom, ST_PointFromText(CONCAT('POINT(', ?, ' ', ?, ')')))", [$lng, $lat])
            ->first();

        if (!$ward) {
            return back()->withInput()->with('error', 'ಒದಗಿಸಿದ ಸ್ಥಳವು ಯಾವುದೇ ವಾರ್ಡ್ ಮಿತಿಯಲ್ಲಿ ಕಂಡುಬಂದಿಲ್ಲ. (Location not found within service area).');
        }

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = $file->store('complaints', 'public');
                $imagePaths[] = $path;
            }
        }

        Complaint::create([
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
            'status'         => 'new',
        ]);

        return redirect()->route('complaints.index')
            ->with('success', "ದೂರು ಸಲ್ಲಿಸಲಾಗಿದೆ! (Complaint filed in Ward: {$ward->name})");
    }

    /**
     * Page: Complaints Report
     */
    public function report(Request $request)
    {
        // Check if the request is AJAX or expects JSON
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = Complaint::where('user_id', auth()->id());

                // 1. Date Filtering Logic
                if ($request->filled('fromdate')) {
                    $query->whereDate('created_at', '>=', $request->fromdate);
                }

                if ($request->filled('todate')) {
                    $query->whereDate('created_at', '<=', $request->todate);
                }

                // 2. Eager Load category and use get()
                // We use 'category:id,name' to be memory efficient
                $complaints = $query->with(['category:id,name'])->latest()->get();

                // 3. Map data for JSON response
                // Inside your report method...
                $data = $complaints->map(function ($item, $key) {
                    return [
                        'sl_no'     => $key + 1,
                        'ticket_id' => 'SP-' . $item->id,
                        'category'  => $item->category->name ?? 'General',
                        'status'    => ucfirst(str_replace('-', ' ', $item->status ?? 'New')),
                        // CHANGE THIS LINE: Ensure 'complaints.show' is defined in web.php
                        'url'       => route('complaints.show', $item->id),
                    ];
                });
                return response()->json(['data' => $data], 200);
            } catch (\Exception $e) {
                // Return actual error message for easier debugging in the Browser Console
                return response()->json([
                    'error' => 'Internal Server Error',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        // Standard page load
        return view('public.complaints.report');
    }
}
