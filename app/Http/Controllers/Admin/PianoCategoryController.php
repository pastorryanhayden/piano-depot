<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PianoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PianoCategoryController extends Controller
{
    public function index()
    {
        $categories = PianoCategory::withCount('pianos')
            ->ordered()
            ->paginate(20);

        return view('admin.piano-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.piano-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:piano_categories,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'show_prices' => 'boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['show_prices'] = $request->has('show_prices');
        $validated['is_active'] = $request->has('is_active');
        
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if (empty($validated['sort_order'])) {
            $validated['sort_order'] = PianoCategory::max('sort_order') + 1;
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('piano-categories', 'public');
        }

        $category = PianoCategory::create($validated);

        return redirect()
            ->route('admin.piano-categories.index')
            ->with('success', 'Piano category created successfully!');
    }

    public function show(PianoCategory $pianoCategory)
    {
        $pianoCategory->loadCount('pianos');
        return view('admin.piano-categories.show', compact('pianoCategory'));
    }

    public function edit(PianoCategory $pianoCategory)
    {
        return view('admin.piano-categories.edit', compact('pianoCategory'));
    }

    public function update(Request $request, PianoCategory $pianoCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:piano_categories,slug,' . $pianoCategory->id,
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'show_prices' => 'boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'remove_featured_image' => 'boolean',
        ]);

        $validated['show_prices'] = $request->has('show_prices');
        $validated['is_active'] = $request->has('is_active');

        if ($request->has('remove_featured_image') && $pianoCategory->featured_image) {
            Storage::disk('public')->delete($pianoCategory->featured_image);
            $validated['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($pianoCategory->featured_image) {
                Storage::disk('public')->delete($pianoCategory->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('piano-categories', 'public');
        }

        $pianoCategory->update($validated);

        return redirect()
            ->route('admin.piano-categories.index')
            ->with('success', 'Piano category updated successfully!');
    }

    public function destroy(PianoCategory $pianoCategory)
    {
        if ($pianoCategory->pianos()->count() > 0) {
            return redirect()
                ->route('admin.piano-categories.index')
                ->with('error', 'Cannot delete category with associated pianos. Please reassign or delete the pianos first.');
        }

        if ($pianoCategory->featured_image) {
            Storage::disk('public')->delete($pianoCategory->featured_image);
        }

        $pianoCategory->delete();

        return redirect()
            ->route('admin.piano-categories.index')
            ->with('success', 'Piano category deleted successfully!');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:piano_categories,id',
        ]);

        foreach ($validated['categories'] as $index => $categoryId) {
            PianoCategory::where('id', $categoryId)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}