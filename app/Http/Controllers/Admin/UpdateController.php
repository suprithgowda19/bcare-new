<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function index()
    {
        $updates = Update::latest()->get();
        return view('admin.updates.index', compact('updates'));
    }

    public function create()
    {
        return view('admin.updates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'tag_name' => 'nullable|string|max:50',
            'about'    => 'nullable|string|max:500',
            'content'  => 'required|string',
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'   => 'required|in:active,inactive',
        ], [
            'title.required'   => 'A title is required for this update.',
            'content.required' => 'Please provide the detailed content.',
            'image.required'   => 'You must upload an image for the update.',
            'image.image'      => 'The file must be a valid image format.',
            'status.required'  => 'Please select whether this update is active or inactive.',
        ]);

        $imagePath = $request->file('image')->store('updates', 'public');

        Update::create([
            'title'    => $request->title,
            'tag_name' => $request->tag_name,
            'about'    => $request->about,
            'content'  => $request->content,
            'image'    => $imagePath,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.updates.index')->with('success', 'Update created successfully.');
    }

    public function show(Update $update)
    {
        return view('admin.updates.show', compact('update'));
    }

    public function edit(Update $update)
    {
        return view('admin.updates.edit', compact('update'));
    }

    public function update(Request $request, Update $update)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'tag_name' => 'nullable|string|max:50',
            'about'    => 'nullable|string|max:500',
            'content'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'   => 'required|in:active,inactive',
        ], [
            'title.required'   => 'The title cannot be empty.',
            'content.required' => 'The content field is mandatory.',
        ]);

        $data = $request->only(['title', 'tag_name', 'about', 'content', 'status']);

        if ($request->hasFile('image')) {
            if ($update->image) {
                Storage::disk('public')->delete($update->image);
            }
            $data['image'] = $request->file('image')->store('updates', 'public');
        }

        $update->update($data);

        return redirect()->route('admin.updates.index')->with('success', 'Update modified successfully.');
    }

    public function destroy(Update $update)
    {
        if ($update->image) {
            Storage::disk('public')->delete($update->image);
        }
        $update->delete();
        return redirect()->route('admin.updates.index')->with('success', 'Update deleted successfully.');
    }
}