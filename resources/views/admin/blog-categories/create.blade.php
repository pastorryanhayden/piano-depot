@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Create Category</h1>
        <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
            Back to Categories
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-bold">Please fix the following errors:</h3>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="max-w-2xl">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('admin.blog-categories.store') }}" method="POST" data-controller="slug-generator">
                    @csrf
                    
                    <div class="form-control mb-4">
                        <label for="name" class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" name="name" id="name" class="input input-bordered @error('name') input-error @enderror" 
                               value="{{ old('name') }}" required data-slug-generator-target="source">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-4">
                        <label for="slug" class="label">
                            <span class="label-text">Slug</span>
                            <span class="label-text-alt">Leave empty to auto-generate</span>
                        </label>
                        <input type="text" name="slug" id="slug" class="input input-bordered @error('slug') input-error @enderror" 
                               value="{{ old('slug') }}" data-slug-generator-target="slug">
                        @error('slug')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-6">
                        <label for="description" class="label">
                            <span class="label-text">Description</span>
                            <span class="label-text-alt">Optional</span>
                        </label>
                        <textarea name="description" id="description" rows="3" 
                                  class="textarea textarea-bordered @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const application = window.Stimulus ? window.Stimulus.application : null;
    if (application) {
        application.register('slug-generator', class extends window.Controller {
            static targets = ['source', 'slug'];
            
            connect() {
                this.sourceTarget.addEventListener('blur', () => {
                    if (!this.slugTarget.value) {
                        const slug = this.sourceTarget.value
                            .toLowerCase()
                            .replace(/[^\w\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/--+/g, '-')
                            .trim();
                        this.slugTarget.value = slug;
                    }
                });
            }
        });
    }
});
</script>
@endpush