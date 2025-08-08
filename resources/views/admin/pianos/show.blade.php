@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $piano->brand }} {{ $piano->model }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.pianos.edit', $piano) }}" class="btn btn-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Piano
            </a>
            <a href="{{ route('admin.pianos.index') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Featured Image -->
            @if($piano->featured_image)
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Featured Image</h2>
                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $piano->featured_image) }}" 
                                 alt="{{ $piano->brand }} {{ $piano->model }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Gallery Images -->
            @if($piano->gallery_images && count($piano->gallery_images) > 0)
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Gallery Images</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($piano->gallery_images as $image)
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Gallery image" 
                                         class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                                         onclick="openImageModal(this.src)">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Description -->
            @if($piano->description)
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Description</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($piano->description)) !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Specifications -->
            @if($piano->specifications && count($piano->specifications) > 0)
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Specifications</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($piano->specifications as $spec)
                                @if(strpos($spec, ':') !== false)
                                    @php
                                        [$key, $value] = explode(':', $spec, 2);
                                    @endphp
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="font-medium">{{ trim($key) }}:</span>
                                        <span>{{ trim($value) }}</span>
                                    </div>
                                @else
                                    <div class="py-2 border-b border-gray-100">
                                        <span>{{ $spec }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Piano Details -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Piano Details</h2>
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-500">Brand</span>
                            <p class="font-semibold">{{ $piano->brand }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-500">Model</span>
                            <p class="font-semibold">{{ $piano->model }}</p>
                        </div>

                        @if($piano->year)
                            <div>
                                <span class="text-sm text-gray-500">Year</span>
                                <p class="font-semibold">{{ $piano->year }}</p>
                            </div>
                        @endif

                        <div>
                            <span class="text-sm text-gray-500">Condition</span>
                            <div class="badge badge-outline mt-1
                                {{ $piano->condition == 'new' ? 'badge-success' : '' }}
                                {{ $piano->condition == 'used' ? 'badge-warning' : '' }}
                                {{ $piano->condition == 'restored' ? 'badge-info' : '' }}">
                                {{ ucfirst($piano->condition) }}
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-500">Price</span>
                            <p class="text-2xl font-bold text-primary">${{ number_format($piano->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Status & Actions</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Availability</span>
                            @if($piano->is_available)
                                <div class="badge badge-success">Available</div>
                            @else
                                <div class="badge badge-error">Unavailable</div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Featured</span>
                            @if($piano->is_featured)
                                <div class="badge badge-warning">Featured</div>
                            @else
                                <div class="badge badge-ghost">Not Featured</div>
                            @endif
                        </div>

                        <div class="pt-4 border-t">
                            <form method="POST" action="{{ route('admin.pianos.toggle-featured', $piano) }}" class="mb-4">
                                @csrf
                                <button type="submit" class="btn btn-outline w-full {{ $piano->is_featured ? 'btn-warning' : 'btn-ghost' }}">
                                    @if($piano->is_featured)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Remove Featured
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                        Mark as Featured
                                    @endif
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.pianos.destroy', $piano) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this piano? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error btn-outline w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Piano
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Metadata</h2>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="text-gray-500">Created:</span>
                            <span>{{ $piano->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Updated:</span>
                            <span>{{ $piano->updated_at->format('M j, Y g:i A') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">ID:</span>
                            <span class="font-mono">{{ $piano->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="modal">
    <div class="modal-box max-w-4xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <img id="modalImage" src="" alt="Full size image" class="w-full h-auto">
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</div>

<script>
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageSrc;
    modal.showModal();
}
</script>
@endsection