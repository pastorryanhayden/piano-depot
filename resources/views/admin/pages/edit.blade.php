@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Page</h1>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Pages
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Page Details</h2>
                        
                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Title <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $page->title) }}" 
                                   class="input input-bordered w-full @error('title') input-error @enderror" 
                                   placeholder="Enter page title" required>
                            @error('title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Slug</span>
                                <span class="label-text-alt">Leave blank to auto-generate</span>
                            </label>
                            <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" 
                                   class="input input-bordered w-full @error('slug') input-error @enderror" 
                                   placeholder="page-url-slug">
                            @error('slug')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Menu Title</span>
                                <span class="label-text-alt">Leave blank to use page title</span>
                            </label>
                            <input type="text" name="menu_title" value="{{ old('menu_title', $page->menu_title) }}" 
                                   class="input input-bordered w-full @error('menu_title') input-error @enderror" 
                                   placeholder="Short title for menus">
                            @error('menu_title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Page Type <span class="text-error">*</span></span>
                            </label>
                            <select name="page_type" class="select select-bordered w-full @error('page_type') select-error @enderror" required>
                                <option value="">Select page type</option>
                                @foreach($pageTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('page_type', $page->page_type) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('page_type')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Content</span>
                            </label>
                            <textarea name="content" rows="10" 
                                      class="textarea textarea-bordered w-full @error('content') textarea-error @enderror" 
                                      placeholder="Page content...">{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Meta Description</span>
                                <span class="label-text-alt">Max 160 characters</span>
                            </label>
                            <textarea name="meta_description" rows="3" maxlength="160"
                                      class="textarea textarea-bordered w-full @error('meta_description') textarea-error @enderror" 
                                      placeholder="Brief description for search engines...">{{ old('meta_description', $page->meta_description) }}</textarea>
                            @error('meta_description')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Publishing</h2>
                        
                        <div class="form-control mb-4">
                            <label class="label cursor-pointer">
                                <span class="label-text">Published</span>
                                <input type="checkbox" name="is_published" value="1" 
                                       class="checkbox checkbox-primary" 
                                       {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                            </label>
                        </div>

                        <div class="form-control mb-4">
                            <label class="label cursor-pointer">
                                <span class="label-text">Show in Menu</span>
                                <input type="checkbox" name="show_in_menu" value="1" 
                                       class="checkbox checkbox-primary" 
                                       {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                            </label>
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Menu Order</span>
                            </label>
                            <input type="number" name="menu_order" value="{{ old('menu_order', $page->menu_order) }}" 
                                   min="0" class="input input-bordered w-full @error('menu_order') input-error @enderror">
                            @error('menu_order')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Page Hierarchy</h2>
                        
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Parent Page</span>
                            </label>
                            <select name="parent_id" class="select select-bordered w-full @error('parent_id') select-error @enderror">
                                <option value="">— No Parent —</option>
                                @foreach($pages as $parentPage)
                                    <option value="{{ $parentPage->id }}" {{ old('parent_id', $page->parent_id) == $parentPage->id ? 'selected' : '' }}>
                                        {{ $parentPage->title }}
                                    </option>
                                    @foreach($parentPage->children as $childPage)
                                        @if($childPage->id != $page->id)
                                            <option value="{{ $childPage->id }}" {{ old('parent_id', $page->parent_id) == $childPage->id ? 'selected' : '' }}>
                                                — {{ $childPage->title }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                            @error('parent_id')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Page Info</h2>
                        <div class="text-sm space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created:</span>
                                <span>{{ $page->created_at->format('M d, Y g:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Updated:</span>
                                <span>{{ $page->updated_at->format('M d, Y g:i A') }}</span>
                            </div>
                            @if($page->children->count() > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Child Pages:</span>
                                    <span class="badge badge-info">{{ $page->children->count() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary flex-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V2" />
                                </svg>
                                Update Page
                            </button>
                            <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection