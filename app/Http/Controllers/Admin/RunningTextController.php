<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RunningTextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $runningTexts = \App\Models\RunningText::orderBy('order')->get();
        return view('admin.running-texts.index', compact('runningTexts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.running-texts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'link' => ['nullable', 'string', 'max:500', new \App\Rules\SiteLink()],
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        \App\Models\RunningText::create($data);

        return redirect()->route('admin.running-texts.index')
            ->with('success', 'Running text berhasil ditambahkan.');
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
    public function edit(\App\Models\RunningText $runningText)
    {
        return view('admin.running-texts.edit', compact('runningText'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\RunningText $runningText)
    {
        $request->validate([
            'text' => 'required|string',
            'link' => ['nullable', 'string', 'max:500', new \App\Rules\SiteLink()],
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $runningText->update($data);

        return redirect()->route('admin.running-texts.index')
            ->with('success', 'Running text berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\RunningText $runningText)
    {
        $runningText->delete();
        return redirect()->route('admin.running-texts.index')
            ->with('success', 'Running text berhasil dihapus.');
    }
}
