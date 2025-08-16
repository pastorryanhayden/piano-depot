@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Piano Categories</h1>
        <a href="{{ route('admin.piano-categories.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Category
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

    @if(session('error'))
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Pianos</th>
                            <th>Show Prices</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-categories">
                        @forelse($categories as $category)
                            <tr data-id="{{ $category->id }}" class="hover">
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button class="btn btn-ghost btn-xs handle cursor-move">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                            </svg>
                                        </button>
                                        {{ $category->sort_order }}
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if($category->featured_image)
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12">
                                                    <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" />
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold">{{ $category->name }}</div>
                                            @if($category->description)
                                                <div class="text-sm opacity-50">{{ Str::limit($category->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="text-sm">{{ $category->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge badge-neutral">{{ $category->pianos_count }}</span>
                                </td>
                                <td>
                                    @if($category->show_prices)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-ghost">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-error">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.piano-categories.edit', $category) }}" 
                                           class="btn btn-ghost btn-xs" 
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.piano-categories.destroy', $category) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this category?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-ghost btn-xs text-error" 
                                                    title="Delete"
                                                    @if($category->pianos_count > 0) disabled @endif>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <div class="text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p>No categories found</p>
                                        <a href="{{ route('admin.piano-categories.create') }}" class="btn btn-primary btn-sm mt-4">Create First Category</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortableTable = document.getElementById('sortable-categories');
    if (sortableTable) {
        new Sortable(sortableTable, {
            handle: '.handle',
            animation: 150,
            onEnd: function(evt) {
                const categories = [];
                sortableTable.querySelectorAll('tr').forEach((row) => {
                    categories.push(row.dataset.id);
                });

                fetch('{{ route('admin.piano-categories.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ categories })
                });
            }
        });
    }
});
</script>
@endpush
@endsection