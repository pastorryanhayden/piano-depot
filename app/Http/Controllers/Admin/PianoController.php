<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Piano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PianoController extends Controller
{
    public function index(Request $request)
    {
        $query = Piano::query();

        // Apply filters
        if ($request->filled('condition')) {
            $query->condition($request->condition);
        }

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('availability')) {
            $query->where('is_available', $request->availability === 'available');
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'featured');
        }

        $pianos = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.pianos.index', compact('pianos'));
    }

    public function create()
    {
        $conditions = [
            'new' => 'New',
            'used' => 'Used',
            'restored' => 'Restored'
        ];

        return view('admin.pianos.create', compact('conditions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,used,restored',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'specifications.*' => 'string',
            'featured_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        // Handle boolean fields
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle specifications from textarea
        if (isset($validated['specifications']) && count($validated['specifications']) == 1) {
            $specs = explode("\n", $validated['specifications'][0]);
            $validated['specifications'] = array_filter(array_map('trim', $specs));
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('pianos', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store('pianos/gallery', 'public');
            }
            $validated['gallery_images'] = $galleryImages;
        }

        $piano = Piano::create($validated);

        return redirect()
            ->route('admin.pianos.index')
            ->with('success', 'Piano created successfully!');
    }

    public function show(Piano $piano)
    {
        return view('admin.pianos.show', compact('piano'));
    }

    public function edit(Piano $piano)
    {
        $conditions = [
            'new' => 'New',
            'used' => 'Used',
            'restored' => 'Restored'
        ];

        return view('admin.pianos.edit', compact('piano', 'conditions'));
    }

    public function update(Request $request, Piano $piano)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,used,restored',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'specifications.*' => 'string',
            'featured_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'remove_featured_image' => 'boolean',
            'remove_gallery_images' => 'nullable|array',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        // Handle boolean fields
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle specifications from textarea
        if (isset($validated['specifications']) && count($validated['specifications']) == 1) {
            $specs = explode("\n", $validated['specifications'][0]);
            $validated['specifications'] = array_filter(array_map('trim', $specs));
        }

        // Handle featured image removal
        if ($request->has('remove_featured_image') && $piano->featured_image) {
            Storage::disk('public')->delete($piano->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($piano->featured_image) {
                Storage::disk('public')->delete($piano->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('pianos', 'public');
        }

        // Handle gallery images removal
        if ($request->has('remove_gallery_images')) {
            $currentGallery = $piano->gallery_images ?? [];
            $toRemove = $request->remove_gallery_images;
            foreach ($toRemove as $imageToRemove) {
                if (in_array($imageToRemove, $currentGallery)) {
                    Storage::disk('public')->delete($imageToRemove);
                    $currentGallery = array_diff($currentGallery, [$imageToRemove]);
                }
            }
            $validated['gallery_images'] = array_values($currentGallery);
        }

        // Handle new gallery images upload
        if ($request->hasFile('gallery_images')) {
            $existingGallery = $validated['gallery_images'] ?? $piano->gallery_images ?? [];
            $newImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $newImages[] = $image->store('pianos/gallery', 'public');
            }
            $validated['gallery_images'] = array_merge($existingGallery, $newImages);
        }

        $piano->update($validated);

        return redirect()
            ->route('admin.pianos.index')
            ->with('success', 'Piano updated successfully!');
    }

    public function destroy(Piano $piano)
    {
        // Delete associated images
        if ($piano->featured_image) {
            Storage::disk('public')->delete($piano->featured_image);
        }

        if ($piano->gallery_images) {
            foreach ($piano->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $piano->delete();

        return redirect()
            ->route('admin.pianos.index')
            ->with('success', 'Piano deleted successfully!');
    }

    public function toggleFeatured(Piano $piano)
    {
        $piano->update(['is_featured' => !$piano->is_featured]);

        $status = $piano->is_featured ? 'featured' : 'unfeatured';

        return back()->with('success', "Piano {$status} successfully!");
    }

    public function export()
    {
        $pianos = Piano::all();
        
        $filename = 'pianos_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($pianos) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Brand',
                'Model', 
                'Year',
                'Price',
                'Condition',
                'Description',
                'Specifications',
                'Is Available',
                'Is Featured',
                'Created At'
            ]);

            foreach ($pianos as $piano) {
                fputcsv($file, [
                    $piano->brand,
                    $piano->model,
                    $piano->year,
                    $piano->price,
                    $piano->condition,
                    $piano->description,
                    is_array($piano->specifications) ? implode('; ', $piano->specifications) : '',
                    $piano->is_available ? 'Yes' : 'No',
                    $piano->is_featured ? 'Yes' : 'No',
                    $piano->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        // Remove header row
        $headers = array_shift($data);
        
        $imported = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            try {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Map CSV columns to piano attributes
                $pianoData = [
                    'brand' => $row[0] ?? '',
                    'model' => $row[1] ?? '',
                    'year' => !empty($row[2]) ? (int)$row[2] : null,
                    'price' => (float)($row[3] ?? 0),
                    'condition' => strtolower($row[4] ?? 'used'),
                    'description' => $row[5] ?? null,
                    'specifications' => !empty($row[6]) ? explode('; ', $row[6]) : null,
                    'is_available' => strtolower($row[7] ?? 'yes') === 'yes',
                    'is_featured' => strtolower($row[8] ?? 'no') === 'yes'
                ];

                // Validate required fields
                if (empty($pianoData['brand']) || empty($pianoData['model'])) {
                    $errors[] = "Row " . ($index + 2) . ": Brand and Model are required";
                    continue;
                }

                // Validate condition
                if (!in_array($pianoData['condition'], ['new', 'used', 'restored'])) {
                    $pianoData['condition'] = 'used'; // Default fallback
                }

                Piano::create($pianoData);
                $imported++;

            } catch (\Exception $e) {
                $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $message = "Successfully imported {$imported} pianos.";
        if (count($errors) > 0) {
            $message .= " " . count($errors) . " rows had errors.";
        }

        return redirect()
            ->route('admin.pianos.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    public function showImportForm()
    {
        return view('admin.pianos.import');
    }
}