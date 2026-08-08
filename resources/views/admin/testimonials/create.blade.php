@extends('layouts.admin')

@section('title', 'Tambah Testimoni')
@section('page-title', 'Tambah Testimoni')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Testimoni Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Jabatan/Profesi</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: CEO, Mahasiswa, Alumni">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="company" class="form-label">Perusahaan/Institusi</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" 
                               id="company" name="company" value="{{ old('company') }}" placeholder="Contoh: PT. ABC, Universitas XYZ">
                        @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: +62 812-3456-7890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Testimoni <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                               id="avatar" name="avatar" accept="image/*">
                        <div class="form-text">Format yang didukung: JPG, PNG, GIF, WebP. Maksimal 2MB. Rekomendasi ukuran: 300x300px.</div>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select class="form-control @error('rating') is-invalid @enderror" 
                                        id="rating" name="rating">
                                    <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 Bintang</option>
                                    <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 Bintang</option>
                                    <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 Bintang</option>
                                    <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 Bintang</option>
                                    <option value="5" {{ old('rating', '5') == '5' ? 'selected' : '' }}>5 Bintang</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category">
                                    <option value="student" {{ old('category', 'student') == 'student' ? 'selected' : '' }}>Siswa</option>
                                    <option value="alumni" {{ old('category') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                    <option value="parent" {{ old('category') == 'parent' ? 'selected' : '' }}>Orang Tua</option>
                                    <option value="teacher" {{ old('category') == 'teacher' ? 'selected' : '' }}>Guru</option>
                                    <option value="staff" {{ old('category') == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="community" {{ old('category') == 'community' ? 'selected' : '' }}>Masyarakat</option>
                                    <option value="partner" {{ old('category') == 'partner' ? 'selected' : '' }}>Mitra</option>
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
                                        Testimoni Unggulan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" 
                                           value="1" {{ old('is_approved', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_approved">
                                        Disetujui
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public" 
                                           value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_public">
                                        Tampilkan Publik
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
