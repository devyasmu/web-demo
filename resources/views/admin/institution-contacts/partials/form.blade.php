@php
    $institutionContact = $institutionContact ?? null;
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lembaga <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name', $institutionContact->name ?? '') }}"
                   placeholder="Contoh: Yayasan, MTs, SMP" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="contact_person" class="form-label">Nama CP</label>
            <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                   id="contact_person" name="contact_person" value="{{ old('contact_person', $institutionContact->contact_person ?? '') }}"
                   placeholder="Contoh: Admin PPDB MTs">
            @error('contact_person')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="phone" class="form-label">Nomor WhatsApp</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                   id="phone" name="phone" value="{{ old('phone', $institutionContact->phone ?? '') }}"
                   placeholder="Contoh: 085785377790">
            <small class="form-text text-muted">Boleh 08xx atau +62. Jika kosong, tombol mengarah ke halaman kontak.</small>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="sort_order" class="form-label">Urutan</label>
            <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                   id="sort_order" name="sort_order" value="{{ old('sort_order', $institutionContact->sort_order ?? 0) }}">
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="icon" class="form-label">Icon</label>
            <div class="input-group">
                <span class="input-group-text"><i id="iconPreview" class="{{ old('icon', $institutionContact->icon ?? 'bi bi-whatsapp') }}"></i></span>
                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                       id="icon" name="icon" value="{{ old('icon', $institutionContact->icon ?? 'bi bi-whatsapp') }}">
            </div>
            @error('icon')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi Singkat</label>
    <input type="text" class="form-control @error('description') is-invalid @enderror"
           id="description" name="description" value="{{ old('description', $institutionContact->description ?? '') }}"
           placeholder="Contoh: Informasi jenjang madrasah tsanawiyah">
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
               value="1" {{ old('is_active', $institutionContact->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Aktif dan tampil di beranda</label>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('admin.institution-contacts.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle"></i> Simpan
    </button>
</div>

@push('scripts')
<script>
document.getElementById('icon').addEventListener('input', function() {
    const preview = document.getElementById('iconPreview');
    const val = this.value.trim() || 'bi bi-whatsapp';
    preview.className = val.includes('bi ') ? val : 'bi ' + val;
});
</script>
@endpush
