<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with('category')->latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.galleries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable'],
            'is_active' => ['nullable'],
        ]);

        $baseSlug = $validated['slug'] ?? Str::slug($validated['title']);
        $makeUnique = function(string $slug) {
            $original = $slug; $i = 1;
            while (Gallery::where('slug', $slug)->exists()) {
                $slug = $original.'-'.(++$i);
            }
            return $slug;
        };

        $isActive = $request->boolean('is_active', true);
        $order = (int) (Gallery::max('order') ?? 0);
        $created = 0;

        // Create one gallery per uploaded image
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('galleries', 'public');
                Gallery::create([
                    'title' => $validated['title'],
                    'slug' => $makeUnique($index === 0 ? $baseSlug : $baseSlug.'-'.($index + 1)),
                    'description' => $validated['description'] ?? null,
                    'image' => $path,
                    'thumbnail' => $path,
                    'type' => 'image',
                    'video_url' => null,
                    'category_id' => null,
                    'order' => ++$order,
                    'is_active' => $isActive,
                ]);
                $created++;
            }
        } elseif ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('galleries', 'public');
            Gallery::create([
                'title' => $validated['title'],
                'slug' => $makeUnique($baseSlug),
                'description' => $validated['description'] ?? null,
                'image' => $path,
                'thumbnail' => $path,
                'type' => 'image',
                'video_url' => null,
                'category_id' => null,
                'order' => ++$order,
                'is_active' => $isActive,
            ]);
            $created++;
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', $created > 0 ? "Galeri berhasil dibuat ($created item)." : 'Tidak ada gambar yang diunggah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Gallery $gallery)
    {
        $categories = \App\Models\Category::all();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
        ]);

        $gallery->title = $validated['title'];
        $gallery->slug = $validated['slug'] ?? $gallery->slug;
        $gallery->description = $validated['description'] ?? $gallery->description;
        $gallery->content = $validated['content'] ?? $gallery->content;
        $gallery->event_date = $validated['event_date'] ?? $gallery->event_date;
        $gallery->location = $validated['location'] ?? $gallery->location;
        $gallery->is_featured = $request->boolean('is_featured', $gallery->is_featured);
        $gallery->is_active = $request->boolean('is_active', $gallery->is_active);

        // Prefer multiple uploads if provided (save all to images[], first becomes main image)
        if ($request->hasFile('images')) {
            $storedPaths = [];
            foreach ($request->file('images') as $index => $file) {
                if ($file) {
                    $storedPaths[] = $file->store('galleries', 'public');
                }
            }

            if (!empty($storedPaths)) {
                $gallery->images = $storedPaths;
                // set the first as primary image
                $gallery->image = $storedPaths[0];
                $gallery->thumbnail = $storedPaths[0];
            }
        } elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image = $path;
            $gallery->thumbnail = $path;
        }

        if ($request->hasFile('featured_image')) {
            $featuredPath = $request->file('featured_image')->store('galleries', 'public');
            $gallery->featured_image = $featuredPath;
        }

        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
