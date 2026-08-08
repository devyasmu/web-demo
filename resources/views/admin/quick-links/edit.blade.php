@extends('layouts.admin')

@section('title', 'Edit Akses Cepat')
@section('page-title', 'Edit Akses Cepat')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Akses Cepat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.quick-links.update', $quickLink) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $quickLink->title) }}" 
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
                                       id="order" name="order" value="{{ old('order', $quickLink->order) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">URL / Link <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror" 
                               id="url" name="url" value="{{ old('url', $quickLink->url) }}" 
                               placeholder="https://example.com atau /kontak" required>
                        <small class="form-text text-muted">
                            Link akan terbuka di tab baru.
                        </small>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tampilan Ikon</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="text-muted small mb-2">Pilih salah satu: Bootstrap Icon <strong>atau</strong> upload gambar. Jika keduanya diisi, gambar yang ditampilkan.</p>
                                @if($quickLink->image)
                                <div class="mb-2">
                                    <label class="form-label small">Gambar saat ini:</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $quickLink->image) }}" alt="{{ $quickLink->title }}" class="img-thumbnail" style="max-width: 48px; max-height: 48px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                            <label class="form-check-label small" for="remove_image">Hapus gambar (gunakan icon)</label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="icon" class="form-label small">Bootstrap Icon</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i id="iconPreview" class="{{ old('icon', $quickLink->icon) }}"></i></span>
                                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                                   id="icon" name="icon" value="{{ old('icon', $quickLink->icon) }}" 
                                                   placeholder="bi bi-whatsapp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image" class="form-label small">{{ $quickLink->image ? 'Ganti Gambar' : 'Upload Gambar' }}</label>
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
                                   value="1" {{ old('is_active', $quickLink->is_active) ? 'checked' : '' }}>
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
                            <i class="bi bi-check-circle"></i> Update
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
