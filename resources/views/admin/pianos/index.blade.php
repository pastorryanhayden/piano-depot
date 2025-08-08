@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Piano Inventory</h1>
        <div class="flex gap-2">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Bulk Actions
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <a href="{{ route('admin.pianos.import.form') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Import CSV
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pianos.export') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Export CSV
                        </a>
                    </li>
                </ul>
            </div>
            <a href="{{ route('admin.pianos.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Piano
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Filters -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4">Filters</h2>
            <form method="GET" action="{{ route('admin.pianos.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Condition</span>
                    </label>
                    <select name="condition" class="select select-bordered">
                        <option value="">All Conditions</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                        <option value="restored" {{ request('condition') == 'restored' ? 'selected' : '' }}>Restored</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Brand</span>
                    </label>
                    <input type="text" name="brand" value="{{ request('brand') }}" placeholder="Search brand..." class="input input-bordered">
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Min Price</span>
                    </label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="input input-bordered">
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Max Price</span>
                    </label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="No limit" class="input input-bordered">
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Availability</span>
                    </label>
                    <select name="availability" class="select select-bordered">
                        <option value="">All</option>
                        <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Featured</span>
                    </label>
                    <select name="featured" class="select select-bordered">
                        <option value="">All</option>
                        <option value="featured" {{ request('featured') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="not_featured" {{ request('featured') == 'not_featured' ? 'selected' : '' }}>Not Featured</option>
                    </select>
                </div>

                <div class="flex items-end gap-2 md:col-span-3 lg:col-span-6">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.pianos.index') }}" class="btn btn-ghost">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Piano List -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            @if($pianos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Brand & Model</th>
                                <th>Year</th>
                                <th>Condition</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pianos as $piano)
                                <tr>
                                    <td>
                                        @if($piano->featured_image)
                                            <img src="{{ asset('storage/' . $piano->featured_image) }}" 
                                                 alt="{{ $piano->brand }} {{ $piano->model }}" 
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <div class="font-bold">{{ $piano->brand }}</div>
                                            <div class="text-sm text-gray-500">{{ $piano->model }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $piano->year ?: 'N/A' }}</td>
                                    <td>
                                        <div class="badge badge-outline 
                                            {{ $piano->condition == 'new' ? 'badge-success' : '' }}
                                            {{ $piano->condition == 'used' ? 'badge-warning' : '' }}
                                            {{ $piano->condition == 'restored' ? 'badge-info' : '' }}">
                                            {{ ucfirst($piano->condition) }}
                                        </div>
                                    </td>
                                    <td class="font-mono">${{ number_format($piano->price, 2) }}</td>
                                    <td>
                                        @if($piano->is_available)
                                            <div class="badge badge-success">Available</div>
                                        @else
                                            <div class="badge badge-error">Unavailable</div>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.pianos.toggle-featured', $piano) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $piano->is_featured ? 'btn-warning' : 'btn-ghost' }}"
                                                    title="{{ $piano->is_featured ? 'Remove from featured' : 'Mark as featured' }}">
                                                @if($piano->is_featured)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.pianos.show', $piano) }}" class="btn btn-sm btn-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.pianos.edit', $piano) }}" class="btn btn-sm btn-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.pianos.destroy', $piano) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this piano?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-4">
                    {{ $pianos->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.239 0-4.24.906-5.711 2.369l-.021.023A7.963 7.963 0 004 13.477V6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v6.977a7.963 7.963 0 00-2.269 2.892l-.021.023z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No pianos found</h3>
                    <p class="text-gray-500 mb-4">
                        @if(request()->hasAny(['condition', 'brand', 'min_price', 'max_price', 'availability', 'featured']))
                            Try adjusting your filters or
                            <a href="{{ route('admin.pianos.index') }}" class="link link-primary">clear all filters</a>
                        @else
                            Get started by adding your first piano
                        @endif
                    </p>
                    @if(!request()->hasAny(['condition', 'brand', 'min_price', 'max_price', 'availability', 'featured']))
                        <a href="{{ route('admin.pianos.create') }}" class="btn btn-primary">Add Your First Piano</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection