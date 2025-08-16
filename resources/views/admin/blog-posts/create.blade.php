@extends('layouts.admin')

@section('title', 'Create Blog Post')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tiptap/core@2.1.12/dist/index.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tiptap/starter-kit@2.1.12/dist/index.css">
<style>
    .tiptap-editor {
        min-height: 400px;
    }
    .ProseMirror {
        min-height: 400px;
        padding: 1rem;
    }
    .ProseMirror:focus {
        outline: none;
    }
    .ProseMirror h1 { font-size: 2rem; font-weight: bold; margin: 1rem 0; }
    .ProseMirror h2 { font-size: 1.5rem; font-weight: bold; margin: 1rem 0; }
    .ProseMirror h3 { font-size: 1.25rem; font-weight: bold; margin: 1rem 0; }
    .ProseMirror p { margin: 1rem 0; }
    .ProseMirror ul, .ProseMirror ol { padding-left: 2rem; margin: 1rem 0; }
    .ProseMirror li { margin: 0.25rem 0; }
    .ProseMirror blockquote { 
        border-left: 3px solid #e5e7eb; 
        padding-left: 1rem; 
        margin: 1rem 0;
        font-style: italic;
    }
    .ProseMirror code { 
        background-color: #f3f4f6; 
        padding: 0.125rem 0.25rem; 
        border-radius: 0.25rem; 
        font-family: monospace;
    }
    .ProseMirror pre { 
        background-color: #1f2937; 
        color: #f3f4f6; 
        padding: 1rem; 
        border-radius: 0.5rem; 
        overflow-x: auto;
        margin: 1rem 0;
    }
    .ProseMirror pre code { 
        background: transparent; 
        padding: 0;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Create Blog Post</h1>
        <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
            Back to Posts
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

    <form action="{{ route('admin.blog-posts.store') }}" method="POST" enctype="multipart/form-data" data-controller="blog-form">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="form-control">
                            <label for="title" class="label">
                                <span class="label-text">Title</span>
                            </label>
                            <input type="text" name="title" id="title" class="input input-bordered @error('title') input-error @enderror" 
                                   value="{{ old('title') }}" required data-blog-form-target="title">
                            @error('title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label for="slug" class="label">
                                <span class="label-text">Slug</span>
                                <span class="label-text-alt">Leave empty to auto-generate</span>
                            </label>
                            <input type="text" name="slug" id="slug" class="input input-bordered @error('slug') input-error @enderror" 
                                   value="{{ old('slug') }}" data-blog-form-target="slug">
                            @error('slug')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label for="excerpt" class="label">
                                <span class="label-text">Excerpt</span>
                                <span class="label-text-alt">Brief description for listings</span>
                            </label>
                            <textarea name="excerpt" id="excerpt" rows="3" class="textarea textarea-bordered @error('excerpt') textarea-error @enderror">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label for="content" class="label">
                                <span class="label-text">Content</span>
                            </label>
                            <div class="border border-base-300 rounded-lg">
                                <div class="btn-toolbar border-b border-base-300 p-2 flex flex-wrap gap-2" data-blog-form-target="toolbar">
                                    <div class="join">
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleBold" title="Bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 4h7a4 4 0 014 4 4 4 0 01-4 4H6zM6 12h8a4 4 0 014 4 4 4 0 01-4 4H6z" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleItalic" title="Italic">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4h4M8 20h4m-2-16l-2 16" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleStrike" title="Strikethrough">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v4m0 8v4M4 12h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="join">
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#setHeading1" title="Heading 1">H1</button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#setHeading2" title="Heading 2">H2</button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#setHeading3" title="Heading 3">H3</button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#setParagraph" title="Paragraph">P</button>
                                    </div>

                                    <div class="join">
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleBulletList" title="Bullet List">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleOrderedList" title="Numbered List">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-4m0 0l4 4m-4-4V4M3 8h2m0 0h2m-2 0v2m0-2v-2m10 2h6m-6 6h6" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="join">
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleBlockquote" title="Blockquote">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleCode" title="Code">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#toggleCodeBlock" title="Code Block">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="join">
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#setHorizontalRule" title="Horizontal Rule">—</button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#undo" title="Undo">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm join-item" data-action="click->blog-form#redo" title="Redo">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="tiptap-editor" data-blog-form-target="editor"></div>
                            </div>
                            <input type="hidden" name="content" id="content" value="{{ old('content') }}" data-blog-form-target="content">
                            @error('content')
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
                        <h3 class="card-title">Publishing</h3>
                        
                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <span class="label-text">Publish immediately</span>
                                <input type="checkbox" name="is_published" class="checkbox" value="1" {{ old('is_published') ? 'checked' : '' }} data-blog-form-target="publishNow">
                            </label>
                        </div>

                        <div class="form-control" data-blog-form-target="scheduleField">
                            <label for="published_at" class="label">
                                <span class="label-text">Schedule for</span>
                            </label>
                            <input type="datetime-local" name="published_at" id="published_at" class="input input-bordered input-sm" 
                                   value="{{ old('published_at') }}" data-blog-form-target="publishDate">
                            @error('published_at')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label for="author_id" class="label">
                                <span class="label-text">Author</span>
                            </label>
                            <select name="author_id" id="author_id" class="select select-bordered @error('author_id') select-error @enderror" required>
                                <option value="">Select Author</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ old('author_id', auth()->id()) == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label for="category_id" class="label">
                                <span class="label-text">Category</span>
                            </label>
                            <select name="category_id" id="category_id" class="select select-bordered @error('category_id') select-error @enderror">
                                <option value="">Uncategorized</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title">Featured Image</h3>
                        
                        <div class="form-control">
                            <label for="featured_image" class="label">
                                <span class="label-text">Upload Image</span>
                            </label>
                            <input type="file" name="featured_image" id="featured_image" class="file-input file-input-bordered @error('featured_image') file-input-error @enderror" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp" data-blog-form-target="imageInput">
                            @error('featured_image')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt">Max 2MB. JPG, PNG, GIF, SVG, WebP</span>
                            </label>
                        </div>

                        <div class="mt-4 hidden" data-blog-form-target="imagePreview">
                            <img src="" alt="Preview" class="w-full rounded-lg" data-blog-form-target="previewImg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" name="save_draft" value="1" class="btn btn-outline">Save as Draft</button>
            <button type="submit" class="btn btn-primary">Save Post</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@tiptap/core@2.1.12/dist/index.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/starter-kit@2.1.12/dist/index.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/extension-placeholder@2.1.12/dist/index.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const application = window.Stimulus ? window.Stimulus.application : null;
    if (application) {
        application.register('blog-form', class extends window.Controller {
            static targets = ['title', 'slug', 'content', 'editor', 'toolbar', 'publishNow', 'publishDate', 'scheduleField', 'imageInput', 'imagePreview', 'previewImg'];
            
            connect() {
                this.initEditor();
                this.initSlugGeneration();
                this.initPublishToggle();
                this.initImagePreview();
            }
            
            initEditor() {
                const { Editor } = window['@tiptap/core'];
                const { StarterKit } = window['@tiptap/starter-kit'];
                const { Placeholder } = window['@tiptap/extension-placeholder'];
                
                this.editor = new Editor({
                    element: this.editorTarget,
                    extensions: [
                        StarterKit,
                        Placeholder.configure({
                            placeholder: 'Start writing your blog post...',
                        })
                    ],
                    content: this.contentTarget.value || '',
                    onUpdate: ({ editor }) => {
                        this.contentTarget.value = editor.getHTML();
                    }
                });
            }
            
            initSlugGeneration() {
                this.titleTarget.addEventListener('blur', () => {
                    if (!this.slugTarget.value) {
                        const slug = this.titleTarget.value
                            .toLowerCase()
                            .replace(/[^\w\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/--+/g, '-')
                            .trim();
                        this.slugTarget.value = slug;
                    }
                });
            }
            
            initPublishToggle() {
                this.publishNowTarget.addEventListener('change', () => {
                    if (this.publishNowTarget.checked) {
                        this.scheduleFieldTarget.style.display = 'none';
                    } else {
                        this.scheduleFieldTarget.style.display = 'block';
                    }
                });
                this.publishNowTarget.dispatchEvent(new Event('change'));
            }
            
            initImagePreview() {
                this.imageInputTarget.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewImgTarget.src = e.target.result;
                            this.imagePreviewTarget.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        this.imagePreviewTarget.classList.add('hidden');
                    }
                });
            }
            
            toggleBold() {
                this.editor.chain().focus().toggleBold().run();
            }
            
            toggleItalic() {
                this.editor.chain().focus().toggleItalic().run();
            }
            
            toggleStrike() {
                this.editor.chain().focus().toggleStrike().run();
            }
            
            setHeading1() {
                this.editor.chain().focus().toggleHeading({ level: 1 }).run();
            }
            
            setHeading2() {
                this.editor.chain().focus().toggleHeading({ level: 2 }).run();
            }
            
            setHeading3() {
                this.editor.chain().focus().toggleHeading({ level: 3 }).run();
            }
            
            setParagraph() {
                this.editor.chain().focus().setParagraph().run();
            }
            
            toggleBulletList() {
                this.editor.chain().focus().toggleBulletList().run();
            }
            
            toggleOrderedList() {
                this.editor.chain().focus().toggleOrderedList().run();
            }
            
            toggleBlockquote() {
                this.editor.chain().focus().toggleBlockquote().run();
            }
            
            toggleCode() {
                this.editor.chain().focus().toggleCode().run();
            }
            
            toggleCodeBlock() {
                this.editor.chain().focus().toggleCodeBlock().run();
            }
            
            setHorizontalRule() {
                this.editor.chain().focus().setHorizontalRule().run();
            }
            
            undo() {
                this.editor.chain().focus().undo().run();
            }
            
            redo() {
                this.editor.chain().focus().redo().run();
            }
            
            disconnect() {
                if (this.editor) {
                    this.editor.destroy();
                }
            }
        });
    }
});
</script>
@endpush