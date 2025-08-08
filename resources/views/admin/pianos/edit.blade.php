@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Piano: {{ $piano->brand }} {{ $piano->model }}</h1>
        <a href="{{ route('admin.pianos.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.pianos.update', $piano) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Brand <span class="text-red-500">*</span></span>
                        </label>
                        <input type="text" 
                               name="brand" 
                               value="{{ old('brand', $piano->brand) }}" 
                               class="input input-bordered @error('brand') input-error @enderror" 
                               placeholder="e.g., Yamaha, Kawai" 
                               required>
                        @error('brand')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Model <span class="text-red-500">*</span></span>
                        </label>
                        <input type="text" 
                               name="model" 
                               value="{{ old('model', $piano->model) }}" 
                               class="input input-bordered @error('model') input-error @enderror" 
                               placeholder="e.g., U3, G3" 
                               required>
                        @error('model')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Year</span>
                        </label>
                        <input type="number" 
                               name="year" 
                               value="{{ old('year', $piano->year) }}" 
                               class="input input-bordered @error('year') input-error @enderror" 
                               placeholder="e.g., 2020" 
                               min="1800" 
                               max="{{ date('Y') + 1 }}">
                        @error('year')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Price <span class="text-red-500">*</span></span>
                        </label>
                        <input type="number" 
                               name="price" 
                               value="{{ old('price', $piano->price) }}" 
                               class="input input-bordered @error('price') input-error @enderror" 
                               placeholder="0.00" 
                               step="0.01" 
                               min="0" 
                               required>
                        @error('price')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Condition <span class="text-red-500">*</span></span>
                        </label>
                        <select name="condition" class="select select-bordered @error('condition') select-error @enderror" required>
                            <option value="">Select condition</option>
                            @foreach($conditions as $value => $label)
                                <option value="{{ $value }}" {{ old('condition', $piano->condition) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea name="description" 
                              class="textarea textarea-bordered h-32 @error('description') textarea-error @enderror" 
                              placeholder="Enter detailed description of the piano...">{{ old('description', $piano->description) }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Specifications -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Specifications</span>
                        <span class="label-text-alt">Add one specification per line</span>
                    </label>
                    <textarea name="specifications[]" 
                              class="textarea textarea-bordered h-24 @error('specifications') textarea-error @enderror" 
                              placeholder="Height: 131cm&#10;Width: 153cm&#10;Weight: 240kg&#10;Keys: 88">{{ old('specifications') ? implode("\n", old('specifications')) : (is_array($piano->specifications) ? implode("\n", $piano->specifications) : '') }}</textarea>
                    <label class="label">
                        <span class="label-text-alt">Each line will be treated as a separate specification</span>
                    </label>
                    @error('specifications')
                        <label class="label">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Current Featured Image -->
                @if($piano->featured_image)
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Current Featured Image</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $piano->featured_image) }}" 
                                 alt="Current featured image" 
                                 class="w-32 h-32 object-cover rounded">
                            <label class="label cursor-pointer">
                                <input type="checkbox" name="remove_featured_image" class="checkbox checkbox-error mr-2">
                                <span class="label-text">Remove current featured image</span>
                            </label>
                        </div>
                    </div>
                @endif

                <!-- Current Gallery Images -->
                @if($piano->gallery_images && count($piano->gallery_images) > 0)
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Current Gallery Images</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($piano->gallery_images as $image)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Gallery image" 
                                         class="w-full h-24 object-cover rounded">
                                    <label class="label cursor-pointer justify-start mt-2">
                                        <input type="checkbox" name="remove_gallery_images[]" value="{{ $image }}" class="checkbox checkbox-error checkbox-sm mr-2">
                                        <span class="label-text text-xs">Remove</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- New Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">
                                {{ $piano->featured_image ? 'Replace Featured Image' : 'Featured Image' }}
                            </span>
                        </label>
                        <input type="file" 
                               name="featured_image" 
                               accept="image/*" 
                               class="file-input file-input-bordered @error('featured_image') file-input-error @enderror">
                        <label class="label">
                            <span class="label-text-alt">Max size: 2MB</span>
                        </label>
                        @error('featured_image')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Add Gallery Images</span>
                        </label>
                        <input type="file" 
                               name="gallery_images[]" 
                               accept="image/*" 
                               multiple 
                               class="file-input file-input-bordered @error('gallery_images') file-input-error @enderror">
                        <label class="label">
                            <span class="label-text-alt">Max size: 2MB each, multiple files allowed</span>
                        </label>
                        @error('gallery_images')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Status Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label cursor-pointer justify-start">
                            <input type="checkbox" 
                                   name="is_available" 
                                   class="checkbox checkbox-primary mr-3" 
                                   {{ old('is_available', $piano->is_available) ? 'checked' : '' }}>
                            <span class="label-text font-medium">Available for Sale</span>
                        </label>
                        <label class="label">
                            <span class="label-text-alt">Check if this piano is currently available</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer justify-start">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   class="checkbox checkbox-warning mr-3" 
                                   {{ old('is_featured', $piano->is_featured) ? 'checked' : '' }}>
                            <span class="label-text font-medium">Featured Piano</span>
                        </label>
                        <label class="label">
                            <span class="label-text-alt">Featured pianos are highlighted on the website</span>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('admin.pianos.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Piano
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle specifications as array
    const specsTextarea = document.querySelector('textarea[name="specifications[]"]');
    if (specsTextarea) {
        specsTextarea.addEventListener('change', function() {
            const lines = this.value.split('\n').filter(line => line.trim() !== '');
            // Create hidden inputs for each line
            const existingInputs = document.querySelectorAll('input[name="specifications[]"]');
            existingInputs.forEach(input => input.remove());
            
            lines.forEach(line => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'specifications[]';
                hiddenInput.value = line.trim();
                this.parentNode.appendChild(hiddenInput);
            });
        });
    }
});
</script>
@endsection