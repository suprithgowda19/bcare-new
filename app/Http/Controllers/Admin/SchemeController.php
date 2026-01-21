<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchemeController extends Controller
{
    /**
     * Display a listing of schemes.
     */
    public function index()
    {
        $schemes = Scheme::latest()->get();
        return view('admin.schemes.index', compact('schemes'));
    }

    /**
     * Show the form for creating a new scheme.
     */
    public function create()
    {
        return view('admin.schemes.create');
    }

    /**
     * Store a newly created scheme in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'count' => 'required|integer|min:0',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,xml|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = $request->file('image')->store('schemes', 'public');

        Scheme::create([
            'title'  => $request->title,
            'count'  => $request->count,
            'image'  => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme created successfully.');
    }

    /**
     * Show the form for editing the specified scheme.
     */
    public function edit(Scheme $scheme)
    {
        return view('admin.schemes.edit', compact('scheme'));
    }

    /**
     * Update the specified scheme in storage.
     */
    public function update(Request $request, Scheme $scheme)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'count' => 'required|integer|min:0',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,xml|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'count', 'status']);

        if ($request->hasFile('image')) {
            // Delete old SVG if a new one is uploaded
            if ($scheme->image) {
                Storage::disk('public')->delete($scheme->image);
            }
            $data['image'] = $request->file('image')->store('schemes', 'public');
        }

        $scheme->update($data);

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme updated successfully.');
    }

    /**
     * Remove the specified scheme from storage.
     */
    public function destroy(Scheme $scheme)
    {
        if ($scheme->image) {
            Storage::disk('public')->delete($scheme->image);
        }
        $scheme->delete();

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme deleted successfully.');
    }
}