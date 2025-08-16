@extends('layouts.admin')

@section('title', 'Create Piano Category')

@push('styles')
<style>
    .editor-container {
        min-height: 400px;
        position: relative;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
    }
    .editor-content {
        min-height: 400px;
        padding: 1rem;
        background: white;
        border-radius: 0 0 0.5rem 0.5rem;
        outline: none;
    }
    .editor-content:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .editor-content h1 { font-size: 2rem; font-weight: bold; margin: 1rem 0; }
    .editor-content h2 { font-size: 1.5rem; font-weight: bold; margin: 1rem 0; }
    .editor-content h3 { font-size: 1.25rem; font-weight: bold; margin: 1rem 0; }
    .editor-content p { margin: 1rem 0; }
    .editor-content ul, .editor-content ol { padding-left: 2rem; margin: 1rem 0; }
    .editor-content li { margin: 0.25rem 0; }
    .editor-content blockquote { 
        border-left: 3px solid #e5e7eb; 
        padding-left: 1rem; 
        margin: 1rem 0;
        font-style: italic;
    }
    .editor-content code { 
        background-color: #f3f4f6; 
        padding: 0.125rem 0.25rem; 
        border-radius: 0.25rem; 
        font-family: monospace;
    }
    .editor-content pre { 
        background-color: #1f2937; 
        color: #f3f4f6; 
        padding: 1rem; 
        border-radius: 0.5rem; 
        overflow-x: auto;
        margin: 1rem 0;
    }
    .editor-content pre code { 
        background: transparent; 
        padding: 0;
    }
    .editor-toolbar {
        border-bottom: 1px solid #e5e7eb;
        padding: 0.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
        background: #f9fafb;
        border-radius: 0.5rem 0.5rem 0 0;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Create Piano Category</h1>
        <a href="{{ route('admin.piano-categories.index') }}" class="btn btn-ghost">
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
            <form method="POST" action="{{ route('admin.piano-categories.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Name <span class="text-red-500">*</span></span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="input input-bordered @error('name') input-error @enderror" 
                               placeholder="e.g., Acoustic Grand Pianos" 
                               required>
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Slug</span>
                            <span class="label-text-alt">Leave blank to auto-generate</span>
                        </label>
                        <input type="text" 
                               name="slug" 
                               value="{{ old('slug') }}" 
                               class="input input-bordered @error('slug') input-error @enderror" 
                               placeholder="e.g., acoustic-grand-pianos">
                        @error('slug')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Short Description</span>
                    </label>
                    <textarea name="description" 
                              class="textarea textarea-bordered h-24 @error('description') textarea-error @enderror" 
                              placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Category Page Content</span>
                        <span class="label-text-alt">Rich content for the category page</span>
                    </label>
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" onclick="formatText('bold')" class="btn btn-xs btn-ghost" title="Bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z" />
                                </svg>
                            </button>
                            <button type="button" onclick="formatText('italic')" class="btn btn-xs btn-ghost" title="Italic">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4h4M14 20H10M15 4L9 20" />
                                </svg>
                            </button>
                            <div class="divider divider-horizontal m-0"></div>
                            <button type="button" onclick="formatBlock('h1')" class="btn btn-xs btn-ghost" title="Heading 1">H1</button>
                            <button type="button" onclick="formatBlock('h2')" class="btn btn-xs btn-ghost" title="Heading 2">H2</button>
                            <button type="button" onclick="formatBlock('h3')" class="btn btn-xs btn-ghost" title="Heading 3">H3</button>
                            <button type="button" onclick="formatBlock('p')" class="btn btn-xs btn-ghost" title="Paragraph">P</button>
                            <div class="divider divider-horizontal m-0"></div>
                            <button type="button" onclick="formatText('insertUnorderedList')" class="btn btn-xs btn-ghost" title="Bullet List">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <button type="button" onclick="formatText('insertOrderedList')" class="btn btn-xs btn-ghost" title="Numbered List">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-4m0 0l4 4m-4-4V4" />
                                </svg>
                            </button>
                            <div class="divider divider-horizontal m-0"></div>
                            <button type="button" onclick="formatBlock('blockquote')" class="btn btn-xs btn-ghost" title="Quote">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </button>
                            <div class="divider divider-horizontal m-0"></div>
                            <button type="button" onclick="formatText('undo')" class="btn btn-xs btn-ghost" title="Undo">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                            </button>
                            <button type="button" onclick="formatText('redo')" class="btn btn-xs btn-ghost" title="Redo">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
                                </svg>
                            </button>
                        </div>
                        <div id="editor" class="editor-content" contenteditable="true">{!! old('content') ?: '<p>Start writing your category content here...</p>' !!}</div>
                    </div>
                    <input type="hidden" name="content" id="content-input" value="{{ old('content') }}">
                    @error('content')
                        <label class="label">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Featured Image</span>
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
                            <span class="label-text font-medium">Sort Order</span>
                        </label>
                        <input type="number" 
                               name="sort_order" 
                               value="{{ old('sort_order', 0) }}" 
                               class="input input-bordered @error('sort_order') input-error @enderror" 
                               min="0">
                        @error('sort_order')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label cursor-pointer justify-start">
                            <input type="hidden" name="show_prices" value="0">
                            <input type="checkbox" 
                                   name="show_prices" 
                                   value="1"
                                   class="checkbox checkbox-primary mr-3" 
                                   {{ old('show_prices') ? 'checked' : '' }}>
                            <div>
                                <span class="label-text font-medium">Show Prices</span>
                                <span class="label-text-alt block">Display prices for pianos in this category</span>
                            </div>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer justify-start">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   class="checkbox checkbox-primary mr-3" 
                                   checked>
                            <div>
                                <span class="label-text font-medium">Active</span>
                                <span class="label-text-alt block">Category is visible on the website</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('admin.piano-categories.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Simple rich text editor using contenteditable
function formatText(command, value = null) {
    document.execCommand(command, false, value);
    updateHiddenInput();
}

function formatBlock(tag) {
    document.execCommand('formatBlock', false, tag);
    updateHiddenInput();
}

function updateHiddenInput() {
    const editor = document.getElementById('editor');
    const input = document.getElementById('content-input');
    input.value = editor.innerHTML;
}

// Initialize editor
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const input = document.getElementById('content-input');
    
    // Set initial content if exists
    if (input.value) {
        editor.innerHTML = input.value;
    }
    
    // Update hidden input on any change
    editor.addEventListener('input', updateHiddenInput);
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = e.clipboardData.getData('text/html') || e.clipboardData.getData('text/plain');
        document.execCommand('insertHTML', false, text);
        updateHiddenInput();
    });
    
    // Prevent form submission on Enter in editor (use Shift+Enter for new line)
    editor.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.execCommand('insertHTML', false, '<br><br>');
            updateHiddenInput();
        }
    });
});
</script>
@endpush