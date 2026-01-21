<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::latest()->get();
        return view('admin.content.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.content.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:active,inactive',
        ], [
            'title.required'   => 'Please provide a title for this content block.',
            'content.required' => 'The main content area cannot be empty.',
            'status.required'  => 'Please select a status for this entry.',
        ]);

        Content::create($request->all());

        return redirect()->route('admin.content.index')->with('success', 'Content created successfully.');
    }

    public function show(Content $content)
    {
        return view('admin.content.show', compact('content'));
    }

    public function edit(Content $content)
    {
        return view('admin.content.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:active,inactive',
        ], [
            'title.required'   => 'The title field is mandatory.',
            'content.required' => 'Content is required.',
        ]);

        $content->update($request->all());

        return redirect()->route('admin.content.index')->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->route('admin.content.index')->with('success', 'Content deleted successfully.');
    }
}