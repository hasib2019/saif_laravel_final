<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest('created_at')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:20480',
            'youtube_link' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean'
        ]);

        $data = $request->all();
        
        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Move file to public/images/news directory
                $destinationPath = public_path('images/news');
                $image->move($destinationPath, $filename);
                
                // Store relative path for database
                $imagePaths[] = 'images/news/' . $filename;
            }
            $data['images'] = $imagePaths;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $data['video_path'] = $video->storeAs('videos/news', $filename, 'public');
        }

        // Set published_at if status is published and no date is set
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['is_featured'] = $request->has('is_featured');

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
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
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:20480',
            'youtube_link' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean'
        ]);

        $data = $request->all();

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            if ($news->images) {
                foreach ($news->images as $oldImage) {
                    $oldImagePath = public_path($oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Move file to public/images/news directory
                $destinationPath = public_path('images/news');
                $image->move($destinationPath, $filename);
                
                // Store relative path for database
                $imagePaths[] = 'images/news/' . $filename;
            }
            $data['images'] = $imagePaths;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video
            if ($news->video_path) {
                Storage::disk('public')->delete($news->video_path);
            }

            $video = $request->file('video');
            $filename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $data['video_path'] = $video->storeAs('videos/news', $filename, 'public');
        }

        // Set published_at if status is published and no date is set
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['is_featured'] = $request->has('is_featured');

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    public function destroy(News $news)
    {
        // Delete associated files
        if ($news->images) {
            foreach ($news->images as $image) {
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        if ($news->video_path) {
            Storage::disk('public')->delete($news->video_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }

    public function toggleStatus(News $news)
    {
        $status = $news->status === 'published' ? 'draft' : 'published';
        
        $news->update([
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null
        ]);

        return redirect()->back()
            ->with('success', 'News status updated successfully.');
    }

    public function toggleFeatured(News $news)
    {
        $news->update(['is_featured' => !$news->is_featured]);

        return redirect()->back()
            ->with('success', 'Featured status updated successfully.');
    }
}