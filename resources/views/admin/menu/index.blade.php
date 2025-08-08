@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Menu Builder</h1>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Menu Item
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Header Menu
                </h2>
                <div class="text-sm text-gray-600 mb-4">Drag items to reorder. Drag items to the right to create submenus.</div>
                
                @if($headerMenuItems->count() > 0)
                    <div class="menu-builder" data-controller="nested-sortable" 
                         data-nested-sortable-url-value="{{ route('admin.menu.reorder') }}"
                         data-nested-sortable-location-value="header">
                        <ul class="menu-list space-y-2" data-nested-sortable-target="list">
                            @foreach($headerMenuItems as $item)
                                @include('admin.menu.partials.menu-item', ['item' => $item])
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                        <p>No header menu items yet</p>
                        <a href="{{ route('admin.menu.create') }}?location=header" class="btn btn-sm btn-primary mt-4">Add First Item</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Footer Menu
                </h2>
                <div class="text-sm text-gray-600 mb-4">Drag items to reorder. Footer menu typically doesn't have submenus.</div>
                
                @if($footerMenuItems->count() > 0)
                    <div class="menu-builder" data-controller="nested-sortable" 
                         data-nested-sortable-url-value="{{ route('admin.menu.reorder') }}"
                         data-nested-sortable-location-value="footer">
                        <ul class="menu-list space-y-2" data-nested-sortable-target="list">
                            @foreach($footerMenuItems as $item)
                                @include('admin.menu.partials.menu-item', ['item' => $item])
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                        <p>No footer menu items yet</p>
                        <a href="{{ route('admin.menu.create') }}?location=footer" class="btn btn-sm btn-primary mt-4">Add First Item</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title mb-4">Menu Management Tips</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    <div>
                        <p class="font-semibold">Drag & Drop</p>
                        <p class="text-gray-600">Reorder menu items by dragging them up or down</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <div>
                        <p class="font-semibold">Nested Menus</p>
                        <p class="text-gray-600">Drag items to the right to create dropdown submenus</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <div>
                        <p class="font-semibold">Link Types</p>
                        <p class="text-gray-600">Create links to pages, external URLs, or custom routes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .menu-list {
        min-height: 50px;
    }
    .menu-item {
        transition: all 0.3s ease;
    }
    .menu-item.dragging {
        opacity: 0.5;
    }
    .menu-item.drag-over {
        border-top: 2px solid #3b82f6;
    }
    .nested-menu {
        margin-left: 2rem;
        margin-top: 0.5rem;
    }
</style>
@endpush
@endsection