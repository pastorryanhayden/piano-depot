<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['author', 'category'])
            ->latest('published_at')
            ->paginate(20);

        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        $authors = User::orderBy('name')->get();
        
        return view('admin.blog-posts.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog', 'public');
            $validated['featured_image'] = $path;
        }

        $blogPost = BlogPost::create($validated);

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function show(BlogPost $blogPost)
    {
        $blogPost->load(['author', 'category']);
        
        return view('admin.blog-posts.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        $categories = BlogCategory::orderBy('name')->get();
        $authors = User::orderBy('name')->get();
        
        return view('admin.blog-posts.edit', compact('blogPost', 'categories', 'authors'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $blogPost->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = $validated['published_at'] ?? $blogPost->published_at ?? now();
        }

        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }
            $path = $request->file('featured_image')->store('blog', 'public');
            $validated['featured_image'] = $path;
        }

        $blogPost->update($validated);

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }
        
        $blogPost->delete();

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    public function togglePublish(BlogPost $blogPost)
    {
        $blogPost->is_published = !$blogPost->is_published;
        
        if ($blogPost->is_published && !$blogPost->published_at) {
            $blogPost->published_at = now();
        }
        
        $blogPost->save();

        return back()->with('success', 
            $blogPost->is_published 
                ? 'Blog post published successfully!' 
                : 'Blog post unpublished successfully!'
        );
    }
}