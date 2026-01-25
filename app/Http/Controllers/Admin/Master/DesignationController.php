<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DesignationController extends Controller
{
    // 1. LIST with Category context
    public function index()
    {
        // Eager load category and subcategory to show them in the index table
        $designations = Designation::with(['category', 'subcategory'])
            ->withCount('users')
            ->latest()
            ->get();
            
        return view('admin.master.designations.index', compact('designations'));
    }

    // 2. CREATE FORM with Department data
    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('admin.master.designations.create', compact('categories'));
    }

    // 3. SAVE NEW with Department Mapping
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|max:255|unique:designations,name,NULL,id,category_id,' . $request->category_id,
            'category_id'     => 'required|exists:categories,id',
            'subcategory_id'  => 'nullable|exists:sub_categories,id',
        ], [
            'name.unique' => 'This designation already exists within the selected category.'
        ]);

        Designation::create($request->only('name', 'category_id', 'subcategory_id'));

        return redirect()->route('admin.master.designations.index')
                         ->with('success', 'Departmental role created successfully!');
    }

    // 5. EDIT FORM
    public function edit(Designation $designation)
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        // Load subcategories for the currently selected category
        $subCategories = SubCategory::where('category_id', $designation->category_id)->get();
        
        return view('admin.master.designations.edit', compact('designation', 'categories', 'subCategories'));
    }

    // 6. UPDATE
    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name'            => 'required|max:255|unique:designations,name,' . $designation->id . ',id,category_id,' . $request->category_id,
            'category_id'     => 'required|exists:categories,id',
            'subcategory_id'  => 'nullable|exists:sub_categories,id',
        ]);

        $designation->update($request->only('name', 'category_id', 'subcategory_id'));

        return redirect()->route('admin.master.designations.index')
                         ->with('success', 'Designation updated successfully!');
    }

    // 7. DELETE
    public function destroy(Designation $designation)
    {
        if ($designation->users()->exists()) {
            return back()->with('error', 'Cannot delete: Staff members are still assigned to this role.');
        }

        try {
            $designation->delete();
            return redirect()->route('admin.master.designations.index')
                             ->with('success', 'Designation removed.');
        } catch (QueryException $e) {
            return back()->with('error', 'Database error: This role is linked to active workflows.');
        }
    }

    /**
     * AJAX Endpoint for cascading dropdowns in User/Staff creation
     */
    public function getSubCategories(Request $request)
    {
        return response()->json(
            SubCategory::where('category_id', $request->category_id)->get()
        );
    }
}