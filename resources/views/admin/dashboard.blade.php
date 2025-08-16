@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="hero bg-gradient-to-r from-primary to-secondary rounded-lg">
        <div class="hero-content text-center text-primary-content py-8">
            <div class="max-w-md">
                <h1 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="py-3">Manage your Piano Depot content from this dashboard.</p>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Pages Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="card-title text-lg">Pages</h2>
                        <div class="text-3xl font-bold">{{ $stats['total_pages'] }}</div>
                        <p class="text-sm opacity-60">{{ $stats['published_pages'] }} published</p>
                    </div>
                    <div class="text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-primary btn-sm">Manage Pages</a>
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-ghost btn-sm">Add New</a>
                </div>
            </div>
        </div>
        
        <!-- Pianos Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="card-title text-lg">Piano Inventory</h2>
                        <div class="text-3xl font-bold">{{ $stats['total_pianos'] }}</div>
                        <p class="text-sm opacity-60">{{ $stats['available_pianos'] }} available</p>
                    </div>
                    <div class="text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="{{ route('admin.pianos.index') }}" class="btn btn-secondary btn-sm">Manage Pianos</a>
                    <a href="{{ route('admin.pianos.create') }}" class="btn btn-ghost btn-sm">Add New</a>
                </div>
            </div>
        </div>
        
        <!-- Blog Posts Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="card-title text-lg">Blog Posts</h2>
                        <div class="text-3xl font-bold">{{ $stats['total_blog_posts'] }}</div>
                        <p class="text-sm opacity-60">{{ $stats['published_blog_posts'] }} published</p>
                    </div>
                    <div class="text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-accent btn-sm">Manage Posts</a>
                    <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-ghost btn-sm">Add New</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Pages -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Recent Pages</h2>
                @if($recentPages->count() > 0)
                    <ul class="menu menu-compact">
                        @foreach($recentPages as $page)
                            <li>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="justify-between">
                                    <span class="truncate">{{ $page->title }}</span>
                                    <span class="badge badge-sm {{ $page->is_published ? 'badge-success' : 'badge-ghost' }}">
                                        {{ $page->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm opacity-60">No pages yet.</p>
                @endif
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost btn-sm">View All</a>
                </div>
            </div>
        </div>
        
        <!-- Recent Pianos -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Recent Pianos</h2>
                @if($recentPianos->count() > 0)
                    <ul class="menu menu-compact">
                        @foreach($recentPianos as $piano)
                            <li>
                                <a href="{{ route('admin.pianos.edit', $piano) }}" class="justify-between">
                                    <span class="truncate">{{ $piano->brand }} {{ $piano->model }}</span>
                                    <span class="badge badge-sm {{ $piano->is_available ? 'badge-success' : 'badge-error' }}">
                                        {{ $piano->is_available ? 'Available' : 'Sold' }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm opacity-60">No pianos yet.</p>
                @endif
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('admin.pianos.index') }}" class="btn btn-ghost btn-sm">View All</a>
                </div>
            </div>
        </div>
        
        <!-- Recent Blog Posts -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Recent Blog Posts</h2>
                @if($recentBlogPosts->count() > 0)
                    <ul class="menu menu-compact">
                        @foreach($recentBlogPosts as $post)
                            <li>
                                <a href="{{ route('admin.blog-posts.edit', $post) }}" class="justify-between">
                                    <span class="truncate">{{ $post->title }}</span>
                                    <span class="badge badge-sm {{ $post->is_published ? 'badge-success' : 'badge-ghost' }}">
                                        {{ $post->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm opacity-60">No blog posts yet.</p>
                @endif
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-ghost btn-sm">View All</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.pages.create') }}" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Page
                </a>
                <a href="{{ route('admin.pianos.create') }}" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Piano
                </a>
                <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Post
                </a>
                <a href="{{ route('admin.menu.index') }}" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Edit Menu
                </a>
            </div>
        </div>
    </div>
</div>
@endsection