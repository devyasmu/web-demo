<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create', ['faq' => new Faq([
            'is_active' => true,
            'order' => (int) Faq::max('order') + 1,
        ])]);
    }

    public function store(Request $request)
    {
        Faq::create($this->validated($request));

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function show(Faq $faq)
    {
        return redirect()->route('admin.faqs.edit', $faq);
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($this->validated($request));

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $data['order'] = (int) ($data['order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
