<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        return view('admin.dashboard');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.blog-posts.index');
    }

    public function show(BlogPost $blogPost)
    {
        return view('admin.dashboard');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.dashboard');
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        return redirect()->route('admin.blog-posts.index');
    }

    public function destroy(BlogPost $blogPost)
    {
        return redirect()->route('admin.blog-posts.index');
    }

    public function togglePublish(BlogPost $blogPost)
    {
        return back();
    }
}