@extends('layouts.admin')

@section('title', 'Tambah Galeri')
@section('page-title', 'Tambah Galeri')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Galeri Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Galeri <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug URL</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug') }}" placeholder="otomatis-generate-dari-judul">
                        <div class="form-text">URL akan menjadi: /galleries/[slug]. Kosongkan untuk auto-generate dari judul.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Galeri</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Galeri</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Gambar Galeri <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" 
                               id="images" name="images[]" accept="image/*" multiple required>
                        <div class="form-text">Pilih satu atau lebih gambar. Format yang didukung: JPG, PNG, GIF, WebP. Maksimal 5MB per gambar.</div>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Gambar Utama</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" name="featured_image" accept="image/*">
                        <div class="form-text">Gambar utama yang akan ditampilkan sebagai thumbnail galeri.</div>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="event_date" class="form-label">Tanggal Acara</label>
                                <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                                       id="event_date" name="event_date" value="{{ old('event_date') }}">
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                       id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Aula Utama, Jakarta">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                           value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Galeri Unggulan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Galeri Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary me-2">
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
                title: 'Event Gallery Template',
                description: 'Template untuk galeri acara',
                content: '<h2>Galeri Acara</h2><p>Kumpulan foto dari acara yang telah berlangsung...</p><h3>Momen Terbaik</h3><p>Berikut adalah momen-momen terbaik dari acara ini:</p><ul><li>Momen 1</li><li>Momen 2</li><li>Momen 3</li></ul><h3>Peserta Acara</h3><p>Terima kasih kepada semua peserta yang telah hadir...</p>'
            },
            {
                title: 'Activity Gallery Template',
                description: 'Template untuk galeri kegiatan',
                content: '<h2>Galeri Kegiatan</h2><p>Dokumentasi kegiatan yang telah dilaksanakan...</p><h3>Kegiatan Utama</h3><p>Berikut adalah rangkaian kegiatan yang telah dilaksanakan:</p><ol><li>Kegiatan 1</li><li>Kegiatan 2</li><li>Kegiatan 3</li></ol><h3>Hasil Kegiatan</h3><p>Kegiatan ini menghasilkan...</p>'
            },
            {
                title: 'Achievement Gallery Template',
                description: 'Template untuk galeri prestasi',
                content: '<h2>Galeri Prestasi</h2><p>Kumpulan prestasi dan pencapaian yang membanggakan...</p><h3>Prestasi Terbaru</h3><p>Berikut adalah prestasi terbaru yang telah diraih:</p><ul><li>Prestasi 1</li><li>Prestasi 2</li><li>Prestasi 3</li></ul><h3>Penghargaan</h3><p>Berbagai penghargaan yang telah diterima...</p>'
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
