<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::latest()->get();
        return view('admin.about.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ], [
            'title.required'   => 'The section title is mandatory.',
            'content.required' => 'Please provide the descriptive content for the About section.',
            'image.required'   => 'A featured image is required.',
            'image.image'      => 'The file must be a valid image (JPG, PNG, WebP).',
        ]);

        $imagePath = $request->file('image')->store('about', 'public');

        About::create([
            'title'   => $request->title,
            'content' => $request->content,
            'image'   => $imagePath,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.about.index')->with('success', 'About content added successfully.');
    }
    
    public function show(About $about)
    {
        return view('admin.about.show', compact('about'));
    }
    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ], [
            'title.required'   => 'Title cannot be empty.',
            'content.required' => 'Description content is required.',
        ]);

        $data = $request->only(['title', 'content', 'status']);

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        $about->update($data);

        return redirect()->route('admin.about.index')->with('success', 'About content updated successfully.');
    }

    public function destroy(About $about)
    {
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }
        $about->delete();
        return redirect()->route('admin.about.index')->with('success', 'About content deleted successfully.');
    }
}