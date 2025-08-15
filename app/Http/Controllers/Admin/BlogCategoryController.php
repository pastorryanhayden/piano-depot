<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('posts')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.blog-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug',
            'description' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        BlogCategory::create($validated);

        return redirect()
            ->route('admin.blog-categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug,' . $blogCategory->id,
            'description' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $blogCategory->update($validated);

        return redirect()
            ->route('admin.blog-categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->posts()->exists()) {
            return redirect()
                ->route('admin.blog-categories.index')
                ->with('error', 'Cannot delete category with existing posts. Please reassign or delete the posts first.');
        }

        $blogCategory->delete();

        return redirect()
            ->route('admin.blog-categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}