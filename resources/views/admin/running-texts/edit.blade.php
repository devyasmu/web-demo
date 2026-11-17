@extends('layouts.admin')

@section('title', 'Edit Running Text')
@section('page-title', 'Edit Running Text')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Running Text</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.running-texts.update', $runningText) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="text" class="form-label">Text <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('text') is-invalid @enderror" 
                                  id="text" name="text" rows="3" required>{{ old('text', $runningText->text) }}</textarea>
                        @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" 
                               id="link" name="link" value="{{ old('link', $runningText->link) }}" placeholder="/berita atau https://...">
                        <div class="form-text">Halaman di website ini: awali dengan <code>/</code> (contoh <code>/berita</code>). Website lain: alamat lengkap <code>https://...</code></div>
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">Urutan</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $runningText->order) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', $runningText->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.running-texts.index') }}" class="btn btn-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
