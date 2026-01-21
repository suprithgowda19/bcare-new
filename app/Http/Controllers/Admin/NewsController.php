<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = News::latest()->get();
        return view('admin.news.index', compact('newsItems'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'about'   => 'nullable|string|max:500',
            'content' => 'required|string',
            'image'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ], [
            'title.required'   => 'Please enter a catchy headline.',
            'content.required' => 'The main news content cannot be empty.',
            'image.required'   => 'A featured image is required for news articles.',
            'image.image'      => 'The file must be an image (jpg, png, etc.).',
        ]);

        $imagePath = $request->file('image')->store('news', 'public');

        News::create([
            'title'   => $request->title,
            'about'   => $request->about,
            'content' => $request->content,
            'image'   => $imagePath,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News published successfully.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'about'   => 'nullable|string|max:500',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'  => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'about', 'content', 'status']);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }
}