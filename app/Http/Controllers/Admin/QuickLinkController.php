<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuickLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuickLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quickLinks = QuickLink::ordered()->get();
        return view('admin.quick-links.index', compact('quickLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.quick-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:512',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active');
        $data['icon'] = $request->icon ?: 'bi bi-link-45deg';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('quick_links', 'public');
        }

        QuickLink::create($data);

        return redirect()->route('admin.quick-links.index')
            ->with('success', 'Akses cepat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuickLink $quickLink)
    {
        return view('admin.quick-links.edit', compact('quickLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuickLink $quickLink)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:512',
            'remove_image' => 'boolean',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image', 'remove_image');
        $data['is_active'] = $request->has('is_active');
        $data['icon'] = $request->icon ?: 'bi bi-link-45deg';

        if ($request->has('remove_image') && $quickLink->image) {
            Storage::disk('public')->delete($quickLink->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($quickLink->image) {
                Storage::disk('public')->delete($quickLink->image);
            }
            $data['image'] = $request->file('image')->store('quick_links', 'public');
        }

        $quickLink->update($data);

        return redirect()->route('admin.quick-links.index')
            ->with('success', 'Akses cepat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuickLink $quickLink)
    {
        if ($quickLink->image) {
            Storage::disk('public')->delete($quickLink->image);
        }
        $quickLink->delete();
        return redirect()->route('admin.quick-links.index')
            ->with('success', 'Akses cepat berhasil dihapus.');
    }
}
