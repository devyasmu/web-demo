@extends('layouts.admin')

@section('title', 'Edit Download')
@section('page-title', 'Edit Download')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit File Download</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.downloads.update', ['download' => $download->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul File <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $download->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug URL</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $download->slug) }}" placeholder="otomatis-generate-dari-judul">
                        <div class="form-text">URL akan menjadi: /downloads/[slug]. Kosongkan untuk auto-generate dari judul.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi File</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $download->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Detail</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15">{{ old('content', $download->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File Download</label>
                        @if($download->file_path)
                            <div class="mb-2">
                                <p class="text-muted small">File saat ini: <a href="{{ asset('storage/' . $download->file_path) }}" target="_blank">{{ basename($download->file_path) }}</a></p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file">
                        <div class="form-text">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR. Maksimal 50MB. Kosongkan jika tidak ingin mengganti file.</div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Gambar Preview</label>
                        @if($download->featured_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $download->featured_image) }}" alt="{{ $download->title }}" 
                                     class="img-thumbnail" style="max-width: 200px;">
                                <p class="text-muted small">Gambar preview saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" name="featured_image" accept="image/*">
                        <div class="form-text">Gambar preview yang akan ditampilkan sebelum download.</div>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category">
                                    <option value="document" {{ old('category', $download->category) == 'document' ? 'selected' : '' }}>Dokumen</option>
                                    <option value="form" {{ old('category', $download->category) == 'form' ? 'selected' : '' }}>Formulir</option>
                                    <option value="template" {{ old('category', $download->category) == 'template' ? 'selected' : '' }}>Template</option>
                                    <option value="guide" {{ old('category', $download->category) == 'guide' ? 'selected' : '' }}>Panduan</option>
                                    <option value="report" {{ old('category', $download->category) == 'report' ? 'selected' : '' }}>Laporan</option>
                                    <option value="other" {{ old('category', $download->category) == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="file_size" class="form-label">Ukuran File (MB)</label>
                                <input type="number" class="form-control @error('file_size') is-invalid @enderror" 
                                       id="file_size" name="file_size" value="{{ old('file_size', $download->file_size) }}" step="0.01" placeholder="Otomatis dihitung">
                                <div class="form-text">Kosongkan untuk auto-calculate dari file yang diupload.</div>
                                @error('file_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="download_count" class="form-label">Jumlah Download</label>
                                <input type="number" class="form-control @error('download_count') is-invalid @enderror" 
                                       id="download_count" name="download_count" value="{{ old('download_count', $download->download_count) }}" min="0">
                                <div class="form-text">Jumlah download saat ini: {{ $download->download_count }}</div>
                                @error('download_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="version" class="form-label">Versi File</label>
                                <input type="text" class="form-control @error('version') is-invalid @enderror" 
                                       id="version" name="version" value="{{ old('version', $download->version) }}" placeholder="Contoh: 1.0, 2.1, v3.0">
                                @error('version')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                           value="1" {{ old('is_featured', $download->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        File Unggulan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', $download->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        File Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="require_login" name="require_login" 
                                           value="1" {{ old('require_login', $download->require_login) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="require_login">
                                        Perlu Login
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary me-2">
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

@push('scripts')
<!-- TinyMCE CDN with API Key -->
<script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY', 'no-api-key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Console log removed
    
    tinymce.init({
        selector: '#content',
        height: 500,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
            'template', 'codesample', 'hr', 'pagebreak', 'nonbreaking', 'toc',
            'imagetools', 'textpattern', 'noneditable', 'quickbars', 'accordion'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help | image | link | media | table | ' +
            'code | fullscreen | preview | searchreplace | visualblocks | ' +
            'charmap | emoticons | insertdatetime | pagebreak | ' +
            'codesample | hr | nonbreaking | toc | accordion',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
        image_advtab: true,
        image_upload_handler: function (blobInfo, success, failure) {
            // Handle image upload
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            
            fetch('/admin/upload-image', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    success(result.url);
                } else {
                    failure('Upload failed: ' + result.message);
                }
            })
            .catch(error => {
                failure('Upload failed: ' + error.message);
            });
        },
        file_picker_callback: function (callback, value, meta) {
            if (meta.filetype === 'image') {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();
                
                input.onchange = function () {
                    const file = this.files[0];
                    const formData = new FormData();
                    formData.append('file', file);
                    
                    fetch('/admin/upload-image', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            callback(result.url, {
                                title: file.name
                            });
                        }
                    });
                };
            }
        },
        templates: [
            {
                title: 'Document Template',
                description: 'Template untuk dokumen resmi',
                content: '<h2>Dokumen Resmi</h2><p>Berikut adalah dokumen resmi yang dapat diunduh:</p><h3>Informasi Dokumen</h3><ul><li><strong>Nama Dokumen:</strong> [Nama Dokumen]</li><li><strong>Versi:</strong> [Versi]</li><li><strong>Tanggal Terbit:</strong> [Tanggal]</li><li><strong>Ukuran File:</strong> [Ukuran]</li></ul><h3>Deskripsi</h3><p>Dokumen ini berisi...</p><h3>Cara Menggunakan</h3><ol><li>Langkah 1</li><li>Langkah 2</li><li>Langkah 3</li></ol>'
            },
            {
                title: 'Form Template',
                description: 'Template untuk formulir',
                content: '<h2>Formulir</h2><p>Silakan unduh dan isi formulir berikut:</p><h3>Informasi Formulir</h3><ul><li><strong>Nama Formulir:</strong> [Nama Formulir]</li><li><strong>Kode Form:</strong> [Kode]</li><li><strong>Batas Waktu:</strong> [Batas Waktu]</li></ul><h3>Petunjuk Pengisian</h3><p>Berikut adalah petunjuk untuk mengisi formulir:</p><ol><li>Isi semua kolom yang wajib diisi</li><li>Pastikan data yang diisi akurat</li><li>Upload dokumen pendukung jika diperlukan</li></ol><h3>Submit Formulir</h3><p>Setelah diisi, kirimkan formulir ke:</p><p><strong>Email:</strong> [Email]<br><strong>Alamat:</strong> [Alamat]</p>'
            },
            {
                title: 'Guide Template',
                description: 'Template untuk panduan',
                content: '<h2>Panduan Penggunaan</h2><p>Berikut adalah panduan lengkap untuk menggunakan sistem:</p><h3>Persyaratan Sistem</h3><ul><li>Persyaratan 1</li><li>Persyaratan 2</li><li>Persyaratan 3</li></ul><h3>Langkah-langkah</h3><ol><li><strong>Langkah 1:</strong> Deskripsi langkah pertama</li><li><strong>Langkah 2:</strong> Deskripsi langkah kedua</li><li><strong>Langkah 3:</strong> Deskripsi langkah ketiga</li></ol><h3>Troubleshooting</h3><p>Jika mengalami masalah:</p><ul><li>Masalah 1: Solusi 1</li><li>Masalah 2: Solusi 2</li></ul><h3>Kontak Support</h3><p>Untuk bantuan lebih lanjut, hubungi:</p><p><strong>Email:</strong> [Email]<br><strong>Telepon:</strong> [Telepon]</p>'
            }
        ],
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        quickbars_insert_toolbar: 'quickimage quicktable',
        contextmenu: 'link image imagetools table spellchecker configurepermanentpen',
        branding: false,
        promotion: false,
        setup: function (editor) {
            editor.on('init', function () {
                // Console log removed
            });
        }
    });
});
</script>
@endpush