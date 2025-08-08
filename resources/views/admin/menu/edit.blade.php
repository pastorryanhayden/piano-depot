@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Menu Item</h1>
        <a href="{{ route('admin.menu.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Menu
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

    <form action="{{ route('admin.menu.update', $menu) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Menu Item Details</h2>
                        
                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Menu Location <span class="text-error">*</span></span>
                            </label>
                            <select name="menu_location" class="select select-bordered w-full @error('menu_location') select-error @enderror" required>
                                <option value="">Select location</option>
                                @foreach($menuLocations as $value => $label)
                                    <option value="{{ $value }}" {{ old('menu_location', $menu->menu_location) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('menu_location')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Link Type <span class="text-error">*</span></span>
                            </label>
                            <div class="flex gap-4">
                                <label class="label cursor-pointer">
                                    <input type="radio" name="type" value="page" class="radio radio-primary" 
                                           {{ old('type', $menu->type) == 'page' ? 'checked' : '' }}
                                           data-action="change->menu-type#toggle">
                                    <span class="label-text ml-2">Page Link</span>
                                </label>
                                <label class="label cursor-pointer">
                                    <input type="radio" name="type" value="external" class="radio radio-primary" 
                                           {{ old('type', $menu->type) == 'external' ? 'checked' : '' }}
                                           data-action="change->menu-type#toggle">
                                    <span class="label-text ml-2">External URL</span>
                                </label>
                                <label class="label cursor-pointer">
                                    <input type="radio" name="type" value="custom" class="radio radio-primary" 
                                           {{ old('type', $menu->type) == 'custom' ? 'checked' : '' }}
                                           data-action="change->menu-type#toggle">
                                    <span class="label-text ml-2">Custom Link</span>
                                </label>
                            </div>
                            @error('type')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4" id="page-select" style="{{ old('type', $menu->type) != 'page' ? 'display:none' : '' }}">
                            <label class="label">
                                <span class="label-text">Select Page <span class="text-error">*</span></span>
                            </label>
                            <select name="page_id" class="select select-bordered w-full @error('page_id') select-error @enderror">
                                <option value="">Select a page</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ old('page_id', $menu->page_id) == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }} ({{ $page->slug }})
                                    </option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4" id="url-input" style="{{ old('type', $menu->type) == 'page' ? 'display:none' : '' }}">
                            <label class="label">
                                <span class="label-text">URL <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="url" value="{{ old('url', $menu->url) }}" 
                                   class="input input-bordered w-full @error('url') input-error @enderror" 
                                   placeholder="https://example.com or /custom-route">
                            @error('url')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Display Title <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $menu->title) }}" 
                                   class="input input-bordered w-full @error('title') input-error @enderror" 
                                   placeholder="Menu item title" required>
                            @error('title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Parent Item</span>
                                <span class="label-text-alt">Leave blank for top-level item</span>
                            </label>
                            <select name="parent_id" class="select select-bordered w-full @error('parent_id') select-error @enderror">
                                <option value="">— No Parent (Top Level) —</option>
                                @foreach($menuItems as $location => $items)
                                    <optgroup label="{{ ucfirst($location) }} Menu">
                                        @foreach($items as $menuItem)
                                            @if($menuItem->id != $menu->id)
                                                <option value="{{ $menuItem->id }}" {{ old('parent_id', $menu->parent_id) == $menuItem->id ? 'selected' : '' }}>
                                                    {{ $menuItem->title }}
                                                </option>
                                                @foreach($menuItem->children as $child)
                                                    @if($child->id != $menu->id)
                                                        <option value="{{ $child->id }}" {{ old('parent_id', $menu->parent_id) == $child->id ? 'selected' : '' }}>
                                                            — {{ $child->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </optgroup>
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
            </div>

            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Settings</h2>
                        
                        <div class="form-control mb-4">
                            <label class="label cursor-pointer">
                                <span class="label-text">Active</span>
                                <input type="checkbox" name="is_active" value="1" 
                                       class="checkbox checkbox-primary" 
                                       {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                            </label>
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Sort Order</span>
                            </label>
                            <input type="number" name="order" value="{{ old('order', $menu->order) }}" 
                                   min="0" class="input input-bordered w-full @error('order') input-error @enderror">
                            @error('order')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Menu Item Info</h2>
                        <div class="text-sm space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created:</span>
                                <span>{{ $menu->created_at->format('M d, Y g:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Updated:</span>
                                <span>{{ $menu->updated_at->format('M d, Y g:i A') }}</span>
                            </div>
                            @if($menu->children->count() > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Child Items:</span>
                                    <span class="badge badge-info">{{ $menu->children->count() }}</span>
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
                                Update Menu Item
                            </button>
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-ghost">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const pageSelect = document.getElementById('page-select');
    const urlInput = document.getElementById('url-input');
    
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'page') {
                pageSelect.style.display = 'block';
                urlInput.style.display = 'none';
            } else {
                pageSelect.style.display = 'none';
                urlInput.style.display = 'block';
            }
        });
    });
});
</script>
@endpush
@endsection