<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.master.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.master.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'name_kn' => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.master.category.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.master.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.master.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'name_kn' => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.master.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.master.category.index')->with('success', 'Category deleted successfully.');
    }
}