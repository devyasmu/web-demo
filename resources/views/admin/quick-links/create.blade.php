@extends('layouts.admin')

@section('title', 'Tambah Akses Cepat')
@section('page-title', 'Tambah Akses Cepat Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Akses Cepat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.quick-links.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" 
                                       placeholder="Contoh: WhatsApp, E-Learning" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="order" class="form-label">Urutan</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', 0) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">URL / Link <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror" 
                               id="url" name="url" value="{{ old('url') }}" 
                               placeholder="https://example.com atau /kontak" required>
                        <small class="form-text text-muted">
                            Link akan terbuka di tab baru. Bisa URL eksternal (https://) atau internal (/programs).
                        </small>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tampilan Ikon</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="text-muted small mb-2">Pilih salah satu: gunakan Bootstrap Icon <strong>atau</strong> upload gambar. Jika keduanya diisi, gambar yang ditampilkan.</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="icon" class="form-label small">Bootstrap Icon</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i id="iconPreview" class="bi bi-link-45deg"></i></span>
                                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                                   id="icon" name="icon" value="{{ old('icon', 'bi bi-link-45deg') }}" 
                                                   placeholder="bi bi-whatsapp">
                                        </div>
                                        <small class="form-text text-muted">Contoh: bi bi-whatsapp, bi bi-telegram</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image" class="form-label small">Atau Upload Gambar</label>
                                        <input type="file" class="form-control form-control-sm @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*">
                                        <small class="form-text text-muted">PNG, JPG, GIF, WebP, SVG. Maks 512KB</small>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.quick-links.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('icon').addEventListener('input', function() {
    const preview = document.getElementById('iconPreview');
    const val = this.value.trim() || 'bi bi-link-45deg';
    preview.className = val.includes('bi ') ? val : 'bi ' + val;
});
</script>
@endpush
@endsection
