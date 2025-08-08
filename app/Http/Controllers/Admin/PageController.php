<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with(['parent', 'children'])
            ->withCount('children')
            ->orderBy('menu_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $pages = Page::whereNull('parent_id')
            ->with('children')
            ->orderBy('menu_order')
            ->get();
        
        $pageTypes = [
            'standard' => 'Standard Page',
            'blog' => 'Blog Page',
            'piano_listing' => 'Piano Listing',
            'contact' => 'Contact Page',
            'landing' => 'Landing Page'
        ];

        return view('admin.pages.create', compact('pages', 'pageTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'menu_title' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:pages,id',
            'page_type' => 'required|in:standard,blog,piano_listing,contact,landing',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:160',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_order' => 'nullable|integer|min:0'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (!isset($validated['menu_title'])) {
            $validated['menu_title'] = $validated['title'];
        }

        $validated['is_published'] = $request->has('is_published');
        $validated['show_in_menu'] = $request->has('show_in_menu');
        $validated['menu_order'] = $validated['menu_order'] ?? 0;

        $page = Page::create($validated);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page created successfully!');
    }

    public function show(Page $page)
    {
        $page->load(['parent', 'children']);
        
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $pages = Page::where('id', '!=', $page->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('menu_order')
            ->get();
        
        $pageTypes = [
            'standard' => 'Standard Page',
            'blog' => 'Blog Page',
            'piano_listing' => 'Piano Listing',
            'contact' => 'Contact Page',
            'landing' => 'Landing Page'
        ];

        return view('admin.pages.edit', compact('page', 'pages', 'pageTypes'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'menu_title' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:pages,id|not_in:' . $page->id,
            'page_type' => 'required|in:standard,blog,piano_listing,contact,landing',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:160',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_order' => 'nullable|integer|min:0'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (!isset($validated['menu_title'])) {
            $validated['menu_title'] = $validated['title'];
        }

        $validated['is_published'] = $request->has('is_published');
        $validated['show_in_menu'] = $request->has('show_in_menu');
        $validated['menu_order'] = $validated['menu_order'] ?? 0;

        if ($validated['parent_id']) {
            $descendants = $page->descendants()->pluck('id')->toArray();
            if (in_array($validated['parent_id'], $descendants)) {
                return back()->withErrors(['parent_id' => 'Cannot set a descendant as parent.']);
            }
        }

        $page->update($validated);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        if ($page->children()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete page with child pages.']);
        }

        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully!');
    }

    public function togglePublish(Page $page)
    {
        $page->update(['is_published' => !$page->is_published]);

        $status = $page->is_published ? 'published' : 'unpublished';

        return back()->with('success', "Page {$status} successfully!");
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'pages' => 'required|array',
            'pages.*.id' => 'required|exists:pages,id',
            'pages.*.order' => 'required|integer|min:0'
        ]);

        foreach ($validated['pages'] as $pageData) {
            Page::where('id', $pageData['id'])->update(['menu_order' => $pageData['order']]);
        }

        return response()->json(['success' => true]);
    }
}