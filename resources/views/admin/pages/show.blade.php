@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Page Preview</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Page
            </a>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Pages
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4">{{ $page->title }}</h2>
                    
                    @if($page->parent)
                        <div class="breadcrumbs text-sm mb-4">
                            <ul>
                                <li><a href="{{ route('admin.pages.index') }}">Pages</a></li>
                                @foreach($page->ancestors() as $ancestor)
                                    <li><a href="{{ route('admin.pages.show', $ancestor) }}">{{ $ancestor->title }}</a></li>
                                @endforeach
                                <li>{{ $page->title }}</li>
                            </ul>
                        </div>
                    @endif

                    <div class="divider"></div>

                    <div class="prose max-w-none">
                        @if($page->content)
                            {!! nl2br(e($page->content)) !!}
                        @else
                            <p class="text-gray-500 italic">No content available for this page.</p>
                        @endif
                    </div>

                    @if($page->page_type === 'blog')
                        <div class="alert alert-info mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>This is a blog listing page. Blog posts will be displayed here automatically.</span>
                        </div>
                    @elseif($page->page_type === 'piano_listing')
                        <div class="alert alert-info mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>This is a piano listing page. Piano inventory will be displayed here automatically.</span>
                        </div>
                    @elseif($page->page_type === 'contact')
                        <div class="alert alert-info mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>This is a contact page. A contact form will be displayed here automatically.</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($page->children->count() > 0)
                <div class="card bg-base-100 shadow-xl mt-6">
                    <div class="card-body">
                        <h3 class="card-title">Child Pages</h3>
                        <div class="overflow-x-auto">
                            <table class="table table-compact">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($page->children as $child)
                                        <tr>
                                            <td>{{ $child->title }}</td>
                                            <td>
                                                <span class="badge badge-outline badge-sm">
                                                    {{ ucfirst(str_replace('_', ' ', $child->page_type)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($child->is_published)
                                                    <span class="badge badge-success badge-sm">Published</span>
                                                @else
                                                    <span class="badge badge-ghost badge-sm">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pages.show', $child) }}" class="btn btn-xs btn-ghost">View</a>
                                                <a href="{{ route('admin.pages.edit', $child) }}" class="btn btn-xs btn-ghost">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h3 class="card-title">Page Information</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600">URL:</span>
                            <div class="text-sm font-mono bg-base-200 p-2 rounded mt-1">
                                /{{ $page->slug }}
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-600">Type:</span>
                            <div class="mt-1">
                                <span class="badge badge-outline">
                                    {{ ucfirst(str_replace('_', ' ', $page->page_type)) }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-600">Status:</span>
                            <div class="mt-1">
                                @if($page->is_published)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-ghost">Draft</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-600">Menu:</span>
                            <div class="mt-1">
                                @if($page->show_in_menu)
                                    <span class="badge badge-info">Visible</span>
                                    <span class="text-sm">Order: {{ $page->menu_order }}</span>
                                @else
                                    <span class="badge badge-ghost">Hidden</span>
                                @endif
                            </div>
                        </div>

                        @if($page->parent)
                            <div>
                                <span class="text-sm text-gray-600">Parent Page:</span>
                                <div class="mt-1">
                                    <a href="{{ route('admin.pages.show', $page->parent) }}" 
                                       class="link link-primary text-sm">
                                        {{ $page->parent->title }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="divider"></div>

                        <div>
                            <span class="text-sm text-gray-600">Created:</span>
                            <div class="text-sm">{{ $page->created_at->format('M d, Y g:i A') }}</div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-600">Last Updated:</span>
                            <div class="text-sm">{{ $page->updated_at->format('M d, Y g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if($page->meta_description)
                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body">
                        <h3 class="card-title">SEO Preview</h3>
                        
                        <div class="space-y-2">
                            <div class="text-blue-600 text-lg hover:underline cursor-pointer">
                                {{ $page->title }}
                            </div>
                            <div class="text-green-700 text-sm">
                                {{ config('app.url') }}/{{ $page->slug }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $page->meta_description }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title">Quick Actions</h3>
                    
                    <div class="space-y-2">
                        <form action="{{ route('admin.pages.toggle-publish', $page) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline w-full">
                                @if($page->is_published)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                    Unpublish Page
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Publish Page
                                @endif
                            </button>
                        </form>

                        <a href="{{ route('admin.pages.create') }}?parent_id={{ $page->id }}" 
                           class="btn btn-sm btn-outline w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Child Page
                        </a>

                        @if($page->children->count() === 0)
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this page?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline btn-error w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Page
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection