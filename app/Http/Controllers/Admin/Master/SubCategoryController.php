<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function index()
    {
        // Prevent N+1 issues by eager loading 'category'
        $subCategories = SubCategory::with('category')->latest()->get();
        return view('admin.master.sub_category.index', compact('subCategories'));
    }

    public function create()
    {
        // Only fetch categories that are active for selection
        $categories = Category::where('status', 'active')->get();
        return view('admin.master.sub_category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'name_kn'     => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'      => 'required|in:active,inactive',
        ], [
            'category_id.required' => 'Please select a parent category.',
            'category_id.exists'   => 'The selected category no longer exists.',
            'name.required'        => 'The sub-category name is required.',
            'name_kn.required'     => 'The Kannada name is required.',
            'image.image'          => 'The file must be a valid image format.',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sub_categories', 'public');
        }

        SubCategory::create($data);

        return redirect()->route('admin.master.sub-category.index')->with('success', 'Sub Category created successfully.');
    }

    public function show(SubCategory $subCategory)
    {
        return view('admin.master.sub_category.show', compact('subCategory'));
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.master.sub_category.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'name_kn'     => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'      => 'required|in:active,inactive',
        ], [
            'name.required'    => 'The title cannot be empty.',
            'name_kn.required' => 'The Kannada title cannot be empty.',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($subCategory->image) {
                Storage::disk('public')->delete($subCategory->image);
            }
            $data['image'] = $request->file('image')->store('sub_categories', 'public');
        }

        $subCategory->update($data);

        return redirect()->route('admin.master.sub-category.index')->with('success', 'Sub Category updated successfully.');
    }

    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->image) {
            Storage::disk('public')->delete($subCategory->image);
        }
        $subCategory->delete();
        return redirect()->route('admin.master.sub-category.index')->with('success', 'Sub Category deleted successfully.');
    }
}