<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the banners.
     */
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created banner in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'image'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'nullable', // Checkbox sends 'on' or nothing
        ], [
            // Custom messages to make inline errors clearer
            'title.required' => 'Please provide a title for the banner.',
            'image.required' => 'An image file is required.',
            'image.image'    => 'The file must be an actual image.',
            'image.max'      => 'The image size should not exceed 2MB.',
        ]);

        // 2. Handle the Image Upload
        $imagePath = $request->file('image')->store('banners', 'public');

        // 3. Create the Database Record
        Banner::create([
            'title'   => $request->title,
            'content' => $request->content,
            'image'   => $imagePath,
            'status'  => $request->has('status') ? 1 : 0,
        ]);

        // 4. Redirect with success message
        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
    }

    /**
     * Display the specified banner.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified banner in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        // 1. Validate with image being optional for updates
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'nullable',
        ]);

        $data = [
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => $request->has('status') ? 1 : 0,
        ];

        // 2. Handle new Image if uploaded
        if ($request->hasFile('image')) {
            // Remove the old physical file to save space
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            // Store the new file
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        // 3. Update the record
        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    /**
     * Remove the specified banner from storage.
     */
    public function destroy(Banner $banner)
    {
        // 1. Delete physical file from storage folder
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        // 2. Delete database record
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}