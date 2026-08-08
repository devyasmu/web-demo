@extends('layouts.admin')

@section('title', 'Tambah FAQ')
@section('page-title', 'Tambah FAQ')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah FAQ Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.faqs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="question" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('question') is-invalid @enderror" 
                               id="question" name="question" value="{{ old('question') }}" required>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="answer" class="form-label">Jawaban <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('answer') is-invalid @enderror" 
                                  id="answer" name="answer" rows="15">{{ old('answer') }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-control @error('category') is-invalid @enderror" 
                                id="category" name="category">
                            <option value="general" {{ old('category', 'general') == 'general' ? 'selected' : '' }}>Umum</option>
                            <option value="admission" {{ old('category') == 'admission' ? 'selected' : '' }}>Penerimaan Siswa</option>
                            <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Akademik</option>
                            <option value="tuition" {{ old('category') == 'tuition' ? 'selected' : '' }}>Biaya Pendidikan</option>
                            <option value="facilities" {{ old('category') == 'facilities' ? 'selected' : '' }}>Fasilitas</option>
                            <option value="programs" {{ old('category') == 'programs' ? 'selected' : '' }}>Program</option>
                            <option value="registration" {{ old('category') == 'registration' ? 'selected' : '' }}>Pendaftaran</option>
                            <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Teknis</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                <label for="sort_order" class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                <div class="form-text">Angka yang lebih kecil akan ditampilkan lebih dulu.</div>
                                @error('sort_order')
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
                                        FAQ Unggulan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        FAQ Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_on_homepage" name="show_on_homepage" 
                                           value="1" {{ old('show_on_homepage') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_on_homepage">
                                        Tampilkan di Homepage
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary me-2">
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
        selector: '#answer',
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
                title: 'General FAQ Template',
                description: 'Template untuk FAQ umum',
                content: '<h3>Jawaban Singkat</h3><p>Jawaban singkat dan langsung untuk pertanyaan yang sering diajukan.</p><h3>Penjelasan Detail</h3><p>Berikut adalah penjelasan yang lebih detail:</p><ul><li>Poin penting 1</li><li>Poin penting 2</li><li>Poin penting 3</li></ul><h3>Langkah-langkah</h3><p>Jika diperlukan, berikut adalah langkah-langkah yang harus dilakukan:</p><ol><li>Langkah pertama</li><li>Langkah kedua</li><li>Langkah ketiga</li></ol><h3>Informasi Tambahan</h3><p>Untuk informasi lebih lanjut, silakan hubungi:</p><p><strong>Kontak:</strong> [Nama Kontak]<br><strong>Telepon:</strong> [Nomor Telepon]<br><strong>Email:</strong> [Email]</p>'
            },
            {
                title: 'Admission FAQ Template',
                description: 'Template untuk FAQ penerimaan siswa',
                content: '<h3>Persyaratan Pendaftaran</h3><p>Berikut adalah persyaratan yang harus dipenuhi:</p><ul><li>Usia minimal [usia] tahun</li><li>Lulus dari [tingkat pendidikan]</li><li>Mengisi formulir pendaftaran</li><li>Melampirkan dokumen yang diperlukan</li></ul><h3>Jadwal Pendaftaran</h3><p>Pendaftaran dibuka pada:</p><ul><li><strong>Tanggal Mulai:</strong> [Tanggal]</li><li><strong>Tanggal Berakhir:</strong> [Tanggal]</li><li><strong>Waktu:</strong> [Waktu]</li></ul><h3>Dokumen yang Diperlukan</h3><ul><li>Fotokopi akta kelahiran</li><li>Fotokopi kartu keluarga</li><li>Pas foto 3x4 (2 lembar)</li><li>Raport/SKHUN</li></ul><h3>Biaya Pendaftaran</h3><p>Biaya pendaftaran sebesar <strong>Rp [jumlah]</strong> yang dapat dibayarkan melalui:</p><ul><li>Transfer bank</li><li>Pembayaran tunai di sekolah</li></ul>'
            },
            {
                title: 'Academic FAQ Template',
                description: 'Template untuk FAQ akademik',
                content: '<h3>Kurikulum</h3><p>Sekolah menggunakan kurikulum [nama kurikulum] yang mencakup:</p><ul><li>Mata pelajaran wajib</li><li>Mata pelajaran pilihan</li><li>Ekstrakurikuler</li><li>Program pengembangan karakter</li></ul><h3>Jadwal Pembelajaran</h3><p>Jadwal pembelajaran dimulai pukul [waktu] dan berakhir pukul [waktu] dengan:</p><ul><li>Istirahat pagi: [waktu]</li><li>Istirahat siang: [waktu]</li><li>Ekstrakurikuler: [waktu]</li></ul><h3>Sistem Penilaian</h3><p>Penilaian dilakukan melalui:</p><ul><li>Ulangan harian (30%)</li><li>Ujian tengah semester (30%)</li><li>Ujian akhir semester (40%)</li></ul><h3>Remedial dan Pengayaan</h3><p>Siswa yang memerlukan bantuan tambahan akan mendapatkan:</p><ul><li>Program remedial untuk siswa yang belum mencapai KKM</li><li>Program pengayaan untuk siswa yang sudah mencapai KKM</li></ul>'
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
