<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $headerMenuItems = MenuItem::where('menu_location', 'header')
            ->whereNull('parent_id')
            ->with(['children', 'page'])
            ->orderBy('order')
            ->get();
            
        $footerMenuItems = MenuItem::where('menu_location', 'footer')
            ->whereNull('parent_id')
            ->with(['children', 'page'])
            ->orderBy('order')
            ->get();

        return view('admin.menu.index', compact('headerMenuItems', 'footerMenuItems'));
    }

    public function create()
    {
        $pages = Page::published()->orderBy('title')->get();
        $menuLocations = ['header' => 'Header Menu', 'footer' => 'Footer Menu'];
        $menuItems = MenuItem::whereNull('parent_id')
            ->with('children')
            ->orderBy('menu_location')
            ->orderBy('order')
            ->get()
            ->groupBy('menu_location');

        return view('admin.menu.create', compact('pages', 'menuLocations', 'menuItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_location' => 'required|in:header,footer',
            'type' => 'required|in:page,external,custom',
            'page_id' => 'nullable|required_if:type,page|exists:pages,id',
            'title' => 'required|string|max:255',
            'url' => 'nullable|required_if:type,external,custom|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? MenuItem::where('menu_location', $validated['menu_location'])
            ->where('parent_id', $validated['parent_id'])
            ->max('order') + 1;

        if ($validated['type'] === 'page' && $validated['page_id']) {
            $page = Page::find($validated['page_id']);
            $validated['url'] = '/' . $page->slug;
        }

        MenuItem::create($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item created successfully!');
    }

    public function edit(MenuItem $menu)
    {
        $pages = Page::published()->orderBy('title')->get();
        $menuLocations = ['header' => 'Header Menu', 'footer' => 'Footer Menu'];
        $menuItems = MenuItem::where('id', '!=', $menu->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('menu_location')
            ->orderBy('order')
            ->get()
            ->groupBy('menu_location');

        return view('admin.menu.edit', compact('menu', 'pages', 'menuLocations', 'menuItems'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'menu_location' => 'required|in:header,footer',
            'type' => 'required|in:page,external,custom',
            'page_id' => 'nullable|required_if:type,page|exists:pages,id',
            'title' => 'required|string|max:255',
            'url' => 'nullable|required_if:type,external,custom|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id|not_in:' . $menu->id,
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        if (!isset($validated['order'])) {
            $validated['order'] = $menu->order;
        }

        if ($validated['type'] === 'page' && $validated['page_id']) {
            $page = Page::find($validated['page_id']);
            $validated['url'] = '/' . $page->slug;
        }

        if ($validated['parent_id']) {
            $descendants = $menu->descendants()->pluck('id')->toArray();
            if (in_array($validated['parent_id'], $descendants)) {
                return back()->withErrors(['parent_id' => 'Cannot set a descendant as parent.']);
            }
        }

        $menu->update($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menu)
    {
        if ($menu->children()->exists()) {
            $menu->children()->update(['parent_id' => $menu->parent_id]);
        }

        $menu->delete();

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.parent_id' => 'nullable|exists:menu_items,id',
            'items.*.order' => 'required|integer|min:0'
        ]);

        foreach ($validated['items'] as $itemData) {
            MenuItem::where('id', $itemData['id'])->update([
                'parent_id' => $itemData['parent_id'] ?? null,
                'order' => $itemData['order']
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function toggle(MenuItem $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);

        $status = $menu->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Menu item {$status} successfully!");
    }
}