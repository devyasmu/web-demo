<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionContact;
use Illuminate\Http\Request;

class InstitutionContactController extends Controller
{
    public function index()
    {
        $institutionContacts = InstitutionContact::ordered()->get();

        return view('admin.institution-contacts.index', compact('institutionContacts'));
    }

    public function create()
    {
        return view('admin.institution-contacts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->has('is_active');
        $data['icon'] = $data['icon'] ?: 'bi bi-whatsapp';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        InstitutionContact::create($data);

        return redirect()->route('admin.institution-contacts.index')
            ->with('success', 'CP lembaga berhasil ditambahkan.');
    }

    public function edit(InstitutionContact $institutionContact)
    {
        return view('admin.institution-contacts.edit', compact('institutionContact'));
    }

    public function update(Request $request, InstitutionContact $institutionContact)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->has('is_active');
        $data['icon'] = $data['icon'] ?: 'bi bi-whatsapp';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $institutionContact->update($data);

        return redirect()->route('admin.institution-contacts.index')
            ->with('success', 'CP lembaga berhasil diperbarui.');
    }

    public function destroy(InstitutionContact $institutionContact)
    {
        $institutionContact->delete();

        return redirect()->route('admin.institution-contacts.index')
            ->with('success', 'CP lembaga berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'description' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
    }
}
