<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Piano;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    public function __invoke(Request $request)
    {
        $stats = [
            'total_pages' => Page::count(),
            'published_pages' => Page::where('is_published', true)->count(),
            'total_pianos' => Piano::count(),
            'available_pianos' => Piano::where('is_available', true)->count(),
            'total_blog_posts' => BlogPost::count(),
            'published_blog_posts' => BlogPost::where('is_published', true)->count(),
        ];
        
        $recentPages = Page::latest()->take(5)->get();
        $recentPianos = Piano::latest()->take(5)->get();
        $recentBlogPosts = BlogPost::with('author')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentPages', 'recentPianos', 'recentBlogPosts'));
    }
}