<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        $maxSliders = Slider::MAX_ITEMS;

        return view('admin.sliders.index', compact('sliders', 'maxSliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Slider::count() >= Slider::MAX_ITEMS) {
            return redirect()->route('admin.sliders.index')
                ->with('error', 'Slider maksimal ' . Slider::MAX_ITEMS . ' item. Hapus atau edit slider yang ada terlebih dahulu.');
        }

        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Slider::count() >= Slider::MAX_ITEMS) {
            return redirect()->route('admin.sliders.index')
                ->with('error', 'Slider maksimal ' . Slider::MAX_ITEMS . ' item. Hapus atau edit slider yang ada terlebih dahulu.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
