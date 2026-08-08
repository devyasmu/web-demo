@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')
@section('page-title', 'Tambah Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Pengumuman Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
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
                        <div class="form-text">URL akan menjadi: /announcements/[slug]. Kosongkan untuk auto-generate dari judul.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Ringkasan Pengumuman</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Pengumuman <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Gambar Utama</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" name="featured_image" accept="image/*">
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="announcement_date" class="form-label">Tanggal Pengumuman</label>
                                <input type="date" class="form-control @error('announcement_date') is-invalid @enderror" 
                                       id="announcement_date" name="announcement_date" value="{{ old('announcement_date') }}">
                                @error('announcement_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Tanggal Berakhir</label>
                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                       id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                                <div class="form-text">Kosongkan jika pengumuman tidak memiliki tanggal berakhir.</div>
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Prioritas</label>
                                <select class="form-control @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority">
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                    <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category">
                                    <option value="general" {{ old('category', 'general') == 'general' ? 'selected' : '' }}>Umum</option>
                                    <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Akademik</option>
                                    <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Acara</option>
                                    <option value="important" {{ old('category') == 'important' ? 'selected' : '' }}>Penting</option>
                                    <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>Berita</option>
                                </select>
                                @error('category')
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
                                           value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Pengumuman Unggulan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                           value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Terbit
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_pinned" name="is_pinned" 
                                           value="1" {{ old('is_pinned') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_pinned">
                                        Pin ke Atas
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary me-2">
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
                title: 'General Announcement Template',
                description: 'Template untuk pengumuman umum',
                content: '<h2>PENGUMUMAN PENTING</h2><p>Diberitahukan kepada seluruh pihak terkait bahwa:</p><h3>Informasi Utama</h3><p>Detail pengumuman...</p><h3>Jadwal</h3><ul><li>Tanggal: [Tanggal]</li><li>Waktu: [Waktu]</li><li>Tempat: [Tempat]</li></ul><h3>Kontak</h3><p>Untuk informasi lebih lanjut, hubungi:</p><p><strong>Nama:</strong> [Nama]<br><strong>Telepon:</strong> [Nomor]<br><strong>Email:</strong> [Email]</p>'
            },
            {
                title: 'Academic Announcement Template',
                description: 'Template untuk pengumuman akademik',
                content: '<h2>PENGUMUMAN AKADEMIK</h2><p>Kepada seluruh siswa dan orang tua,</p><h3>Materi Pengumuman</h3><p>Berikut adalah informasi penting terkait kegiatan akademik:</p><h3>Jadwal Kegiatan</h3><ol><li>Kegiatan 1: [Tanggal] - [Waktu]</li><li>Kegiatan 2: [Tanggal] - [Waktu]</li><li>Kegiatan 3: [Tanggal] - [Waktu]</li></ol><h3>Persyaratan</h3><ul><li>Persyaratan 1</li><li>Persyaratan 2</li><li>Persyaratan 3</li></ul><h3>Catatan Penting</h3><p>Harap diperhatikan hal-hal berikut:</p><ul><li>Catatan 1</li><li>Catatan 2</li></ul>'
            },
            {
                title: 'Event Announcement Template',
                description: 'Template untuk pengumuman acara',
                content: '<h2>PENGUMUMAN ACARA</h2><p>Kami dengan bangga mengundang seluruh pihak untuk menghadiri:</p><h3>Detail Acara</h3><p><strong>Nama Acara:</strong> [Nama Acara]<br><strong>Tanggal:</strong> [Tanggal]<br><strong>Waktu:</strong> [Waktu]<br><strong>Tempat:</strong> [Tempat]</p><h3>Deskripsi Acara</h3><p>Acara ini akan menghadirkan...</p><h3>Pembicara/Tamu</h3><ul><li>[Nama Pembicara 1] - [Jabatan]</li><li>[Nama Pembicara 2] - [Jabatan]</li></ul><h3>Pendaftaran</h3><p>Untuk pendaftaran, silakan hubungi:</p><p><strong>Contact Person:</strong> [Nama]<br><strong>Telepon:</strong> [Nomor]<br><strong>Email:</strong> [Email]</p>'
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
