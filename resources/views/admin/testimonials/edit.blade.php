@extends('layouts.admin')

@section('title', 'Edit Testimoni')
@section('page-title', 'Edit Testimoni')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Testimoni</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.testimonials.update', ['testimonial' => $testimonial->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $testimonial->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Jabatan/Profesi</label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror" 
                               id="position" name="position" value="{{ old('position', $testimonial->position) }}" placeholder="Contoh: Alumni, Wali Siswa, Guru">
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="company" class="form-label">Perusahaan/Institusi</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" 
                               id="company" name="company" value="{{ old('company', $testimonial->company) }}" placeholder="Contoh: PT. ABC, Universitas XYZ">
                        @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="testimonial" class="form-label">Testimoni <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('testimonial') is-invalid @enderror" 
                                  id="testimonial" name="testimonial" rows="15">{{ old('testimonial', $testimonial->testimonial) }}</textarea>
                        @error('testimonial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Profil</label>
                        @if($testimonial->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}" 
                                     class="img-thumbnail" style="max-width: 100px;">
                                <p class="text-muted small">Foto profil saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*">
                        <div class="form-text">Format yang didukung: JPG, PNG, GIF, WebP. Maksimal 2MB. Rekomendasi ukuran: 300x300px.</div>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select class="form-control @error('rating') is-invalid @enderror" 
                                        id="rating" name="rating">
                                    <option value="1" {{ old('rating', $testimonial->rating) == '1' ? 'selected' : '' }}>1 Bintang</option>
                                    <option value="2" {{ old('rating', $testimonial->rating) == '2' ? 'selected' : '' }}>2 Bintang</option>
                                    <option value="3" {{ old('rating', $testimonial->rating) == '3' ? 'selected' : '' }}>3 Bintang</option>
                                    <option value="4" {{ old('rating', $testimonial->rating) == '4' ? 'selected' : '' }}>4 Bintang</option>
                                    <option value="5" {{ old('rating', $testimonial->rating) == '5' ? 'selected' : '' }}>5 Bintang</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">Urutan</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $testimonial->order) }}" min="0">
                                @error('order')
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
                                           value="1" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Testimoni Unggulan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary me-2">
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
<!-- TinyMCE self-hosted -->
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Console log removed
    
    tinymce.init({
        selector: '#testimonial',
        height: 500,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
            'template', 'codesample', 'pagebreak', 'nonbreaking', 'quickbars', 'accordion'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help | image | link | media | table | ' +
            'code | fullscreen | preview | searchreplace | visualblocks | ' +
            'charmap | emoticons | insertdatetime | pagebreak | ' +
            'codesample | nonbreaking | accordion',
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
                title: 'Student Testimonial Template',
                description: 'Template untuk testimoni siswa',
                content: '<h2>Testimoni Siswa</h2><p>Sebagai siswa di [Nama Sekolah], saya sangat berterima kasih atas pengalaman belajar yang luar biasa di sini.</p><h3>Pengalaman Belajar</h3><p>Selama [durasi] belajar di sini, saya merasakan:</p><ul><li>Pembelajaran yang menyenangkan dan interaktif</li><li>Guru-guru yang kompeten dan sabar</li><li>Fasilitas yang memadai dan modern</li><li>Lingkungan belajar yang kondusif</li></ul><h3>Pencapaian</h3><p>Berkat bimbingan yang baik, saya berhasil:</p><ul><li>Meningkatkan prestasi akademik</li><li>Mengembangkan keterampilan sosial</li><li>Memperoleh pengalaman berharga</li></ul><h3>Rekomendasi</h3><p>Saya sangat merekomendasikan [Nama Sekolah] kepada siapa saja yang ingin mendapatkan pendidikan berkualitas.</p><p><strong>Terima kasih,</strong><br>[Nama Siswa]<br>[Kelas/Jurusan]</p>'
            },
            {
                title: 'Alumni Testimonial Template',
                description: 'Template untuk testimoni alumni',
                content: '<h2>Testimoni Alumni</h2><p>Sebagai alumni [Nama Sekolah], saya bangga telah menjadi bagian dari keluarga besar ini.</p><h3>Masa Belajar</h3><p>Selama [tahun] belajar di [Nama Sekolah], saya mendapatkan:</p><ul><li>Pendidikan yang berkualitas tinggi</li><li>Nilai-nilai karakter yang baik</li><li>Persiapan yang matang untuk masa depan</li><li>Kenangan indah yang tak terlupakan</li></ul><h3>Kesuksesan Setelah Lulus</h3><p>Setelah lulus, saya berhasil:</p><ul><li>Melanjutkan ke perguruan tinggi terbaik</li><li>Memperoleh pekerjaan yang sesuai passion</li><li>Berkontribusi positif bagi masyarakat</li></ul><h3>Dampak Positif</h3><p>[Nama Sekolah] telah membentuk saya menjadi pribadi yang:</p><ul><li>Mandiri dan bertanggung jawab</li><li>Berpikir kritis dan kreatif</li><li>Memiliki integritas yang tinggi</li></ul><p><strong>Terima kasih,</strong><br>[Nama Alumni]<br>Angkatan [Tahun]</p>'
            },
            {
                title: 'Parent Testimonial Template',
                description: 'Template untuk testimoni orang tua',
                content: '<h2>Testimoni Orang Tua</h2><p>Sebagai orang tua dari [Nama Anak], saya sangat puas dengan pendidikan yang diberikan [Nama Sekolah].</p><h3>Alasan Memilih [Nama Sekolah]</h3><p>Kami memilih [Nama Sekolah] karena:</p><ul><li>Reputasi akademik yang baik</li><li>Guru-guru yang profesional dan berpengalaman</li><li>Kurikulum yang komprehensif</li><li>Fasilitas yang lengkap dan modern</li><li>Nilai-nilai karakter yang diajarkan</li></ul><h3>Perkembangan Anak</h3><p>Sejak bersekolah di [Nama Sekolah], anak saya menunjukkan perkembangan yang positif:</p><ul><li>Prestasi akademik yang meningkat</li><li>Kepercayaan diri yang berkembang</li><li>Keterampilan sosial yang baik</li><li>Disiplin dan tanggung jawab</li></ul><h3>Komunikasi dengan Sekolah</h3><p>Sekolah sangat terbuka dalam komunikasi dengan orang tua:</p><ul><li>Raport berkala yang detail</li><li>Pertemuan orang tua yang rutin</li><li>Komunikasi yang transparan</li><li>Dukungan penuh untuk perkembangan anak</li></ul><p><strong>Terima kasih,</strong><br>[Nama Orang Tua]<br>Orang tua dari [Nama Anak]</p>'
            }
        ],
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        quickbars_insert_toolbar: 'quickimage quicktable',
        contextmenu: 'link image table',
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
