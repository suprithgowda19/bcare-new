<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->get();
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ], [
            'title.required'   => 'The activity title is required.',
            'content.required' => 'Please provide a detailed description of the activity.',
            'image.required'   => 'An image is mandatory for new activities.',
            'image.image'      => 'The file must be an image (jpg, png, webp).',
            'status.required'  => 'Please select a display status.',
        ]);

        $imagePath = $request->file('image')->store('activities', 'public');

        Activity::create([
            'title'   => $request->title,
            'content' => $request->content,
            'image'   => $imagePath,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.activities.index')->with('success', 'Activity created successfully.');
    }
    
    public function show(Activity $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ], [
            'title.required'   => 'Title cannot be empty.',
            'content.required' => 'Description is mandatory.',
        ]);

        $data = $request->only(['title', 'content', 'status']);

        if ($request->hasFile('image')) {
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $data['image'] = $request->file('image')->store('activities', 'public');
        }

        $activity->update($data);

        return redirect()->route('admin.activities.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }
        $activity->delete();
        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted successfully.');
    }
}