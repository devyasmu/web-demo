@extends('layouts.admin')

@section('title', 'Panduan Admin')
@section('page-title', 'Panduan Admin')

@php
    $toc = [
        'Memulai' => [
            'mulai' => 'Mulai di sini',
            'dasar' => 'Cara kerja umum',
            'gambar' => 'Gambar, ikon & link',
        ],
        'Tampilan & identitas' => [
            'pengaturan' => 'Pengaturan Website',
            'slider' => 'Slider',
            'running-text' => 'Running Text',
            'menu' => 'Menu',
            'akses-cepat' => 'Akses Cepat',
            'cp-lembaga' => 'CP Lembaga',
        ],
        'Konten' => [
            'halaman' => 'Halaman',
            'kategori' => 'Kategori',
            'artikel' => 'Post/Artikel',
            'galeri' => 'Galeri',
            'program' => 'Program',
            'pengumuman' => 'Pengumuman',
            'download' => 'Download',
            'testimoni' => 'Testimoni',
            'statistik' => 'Statistik',
            'fitur' => 'Fitur',
            'faq' => 'FAQ',
        ],
        'Interaksi pengunjung' => [
            'kontak' => 'Kontak (pesan masuk)',
            'komentar' => 'Komentar',
        ],
        'Lain-lain' => [
            'rutinitas' => 'Rutinitas admin',
            'masalah' => 'Masalah umum & solusi',
        ],
    ];
@endphp

@push('styles')
<style>
    .guide-toc { position: sticky; top: 1rem; max-height: calc(100vh - 2rem); overflow-y: auto; }
    .guide-toc .toc-group { font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #6c757d; margin: .9rem 0 .25rem; }
    .guide-toc a { display: block; padding: .2rem .5rem; border-radius: .35rem; color: inherit; text-decoration: none; font-size: .9rem; }
    .guide-toc a:hover { background: rgba(13,110,253,.08); }
    .guide-section { scroll-margin-top: 1rem; }
    .guide-section h6 { font-weight: 700; margin-top: 1rem; }
    .guide-section h6:first-child { margin-top: 0; }
    .guide-section ol, .guide-section ul { padding-left: 1.25rem; }
    .guide-section li { margin-bottom: .25rem; }
    .guide-where { background: #f1f5f9; border-radius: .4rem; padding: .45rem .75rem; font-size: .92rem; }
    .guide-tip { border-left: 4px solid #f59e0b; background: #fffbeb; padding: .6rem .9rem; border-radius: .35rem; margin-top: .75rem; }
    .guide-warn { border-left: 4px solid #dc3545; background: #fff5f5; padding: .6rem .9rem; border-radius: .35rem; margin-top: .75rem; }
    .guide-section table { font-size: .92rem; }
    kbd { font-size: .8rem; }
    @media print {
        .admin-sidebar, .guide-no-print, .guide-toc-col, .alert { display: none !important; }
        main.main-content { width: 100% !important; max-width: 100% !important; flex: 0 0 100% !important; margin: 0 !important; padding: 0 !important; }
        .guide-content-col { flex: 0 0 100% !important; max-width: 100% !important; }
        .guide-section { break-inside: avoid; box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-3 mb-4 guide-toc-col">
        <div class="card guide-toc">
            <div class="card-body">
                <input type="search" id="guideSearch" class="form-control form-control-sm mb-2" placeholder="Cari panduan… (mis. gambar)" aria-label="Cari panduan">
                <button type="button" class="btn btn-sm btn-outline-secondary w-100 mb-1" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak / simpan PDF</button>
                @foreach($toc as $group => $items)
                    <div class="toc-group">{{ $group }}</div>
                    @foreach($items as $id => $label)
                        <a href="#{{ $id }}" data-toc-for="{{ $id }}">{{ $label }}</a>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-9 guide-content-col">
        <div class="alert alert-info d-flex gap-2 align-items-start">
            <i class="bi bi-lightbulb fs-5"></i>
            <div>Panduan ini menjelaskan cara mengelola website dari halaman admin. Gunakan kotak <strong>Cari</strong> di kiri, atau klik nama menu untuk langsung ke penjelasannya. Tombol <strong>Buka menu</strong> membawa Anda ke menu yang sedang dibahas.</div>
        </div>
        <p id="guideNoResult" class="text-muted d-none">Tidak ada bagian panduan yang cocok dengan pencarian.</p>

        {{-- ================================================================ MEMULAI --}}
        <x-admin.guide-section id="mulai" title="Mulai di sini" icon="bi bi-rocket-takeoff">
            <h6>Masuk ke halaman admin</h6>
            <ul>
                <li>Alamat login: <code>{{ url('/masuk-admin') }}</code>. Simpan alamat ini di bookmark.</li>
                <li>Alamat <code>/admin</code> sengaja menampilkan "tidak ditemukan" sebelum login, demi keamanan.</li>
                <li>Setelah 5 kali salah password dalam 1 menit, login dikunci sementara. Tunggu 1 menit lalu coba lagi.</li>
            </ul>

            <h6>Langkah pertama setelah website dipasang</h6>
            <ol>
                <li><strong>Ganti password admin.</strong> Buka <a href="{{ route('admin.site-settings.index') }}">Pengaturan Website</a> → tab <em>Ubah Password</em>. Minimal 8 karakter.</li>
                <li><strong>Isi identitas sekolah</strong> di <a href="{{ route('admin.site-settings.index') }}">Pengaturan Website</a> → tab <em>Umum</em>: nama, logo, alamat, telepon, email, media sosial.</li>
                <li><strong>Periksa Kategori</strong> (Berita, Kegiatan, Prestasi, dan lain-lain). Tambah atau ubah sesuai kebutuhan.</li>
                <li><strong>Atur Menu</strong> navigasi di bagian atas website.</li>
                <li><strong>Isi konten:</strong> slider, artikel, program, galeri, pengumuman, file download.</li>
                <li><strong>Hapus data contoh</strong> yang tidak dipakai (lihat di bawah).</li>
            </ol>

            <h6>Data contoh</h6>
            <p>Website baru biasanya sudah terisi <strong>data contoh</strong> (slider, berita, galeri, dan lain-lain dengan gambar ilustrasi). Artikel contoh diberi catatan "Ini adalah konten contoh…". Gunakan data ini sebagai gambaran pengisian, lalu <strong>edit</strong> dengan data asli atau <strong>hapus</strong> satu per satu dari masing-masing menu.</p>
            <div class="guide-tip"><strong>Tips:</strong> mengedit data contoh sering lebih cepat daripada membuat dari nol. Cukup ganti judul, isi, dan gambarnya.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="dasar" title="Cara kerja umum" icon="bi bi-ui-checks">
            <p>Hampir semua menu bekerja dengan pola yang sama:</p>
            <table class="table table-bordered">
                <tbody>
                    <tr><th style="width:28%">Daftar data</th><td>Klik nama menu di sidebar kiri. Muncul tabel berisi semua data.</td></tr>
                    <tr><th>Tambah</th><td>Tombol <span class="badge bg-primary"><i class="bi bi-plus"></i> Tambah …</span> di kanan atas daftar. Isi form, lalu klik <strong>Simpan</strong>.</td></tr>
                    <tr><th>Edit</th><td>Ikon pensil <i class="bi bi-pencil"></i> pada baris data.</td></tr>
                    <tr><th>Hapus</th><td>Ikon tempat sampah <i class="bi bi-trash"></i>. Data yang dihapus <strong>tidak bisa dikembalikan</strong>.</td></tr>
                    <tr><th>Kolom bertanda <span class="text-danger">*</span></th><td>Wajib diisi. Jika ada yang kurang, kolom berwarna merah beserta pesan kesalahannya.</td></tr>
                    <tr><th>Centang "Aktif"</th><td>Menentukan data tampil di website atau tidak. <strong>Hilangkan centang</strong> untuk menyembunyikan tanpa menghapus.</td></tr>
                    <tr><th>Urutan</th><td>Angka kecil tampil lebih dulu (1, 2, 3, …).</td></tr>
                    <tr><th>Featured / Unggulan</th><td>Artikel bertanda <strong>Featured</strong> tampil di beranda. <strong>Program Unggulan</strong> tampil di bagian atas halaman Program.</td></tr>
                </tbody>
            </table>

            <h6>Editor teks</h6>
            <p>Kolom isi berita, halaman, pengumuman, dan FAQ memakai editor seperti Word: tebal, miring, daftar bernomor, tabel, tautan, dan gambar.</p>
            <ul>
                <li><strong>Menyalin dari Word/WhatsApp:</strong> tempel dengan <kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>V</kbd> (Mac: <kbd>Cmd</kbd>+<kbd>Shift</kbd>+<kbd>V</kbd>) agar format aneh tidak ikut terbawa.</li>
                <li><strong>Subjudul:</strong> pilih teks, lalu pilih <em>Heading</em>/<em>Subjudul</em> pada toolbar. Jangan sekadar memperbesar huruf.</li>
                <li><strong>Gambar di tengah artikel</strong> (khusus berita dan halaman): klik ikon gambar pada toolbar → <em>Upload</em>. Maksimal 5 MB.</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="gambar" title="Gambar, ikon & link" icon="bi bi-image">
            <h6>Ukuran gambar yang disarankan</h6>
            <table class="table table-bordered table-sm">
                <thead class="table-light"><tr><th>Untuk</th><th>Ukuran ideal</th><th>Batas file</th><th>Format</th></tr></thead>
                <tbody>
                    <tr><td>Slider beranda</td><td>1600 × 900 px (mendatar)</td><td>2 MB</td><td>JPG, PNG, GIF</td></tr>
                    <tr><td>Gambar utama artikel</td><td>1200 × 675 px</td><td>2 MB</td><td>JPG, PNG, GIF</td></tr>
                    <tr><td>Gambar program</td><td>1200 × 675 px</td><td>2 MB</td><td>JPG, PNG, GIF, WEBP</td></tr>
                    <tr><td>Foto galeri</td><td>1200 px sisi terpanjang</td><td>5 MB per foto</td><td>JPG, PNG, GIF, WEBP</td></tr>
                    <tr><td>Foto testimoni</td><td>400 × 400 px (persegi)</td><td>2 MB</td><td>JPG, PNG, GIF, WEBP</td></tr>
                    <tr><td>Gambar Akses Cepat</td><td>400 × 300 px</td><td>512 KB</td><td>JPG, PNG, GIF, WEBP, SVG</td></tr>
                    <tr><td>Logo</td><td>PNG latar transparan, tinggi ± 200 px</td><td>2 MB</td><td>PNG, JPG, SVG</td></tr>
                    <tr><td>Favicon (ikon tab browser)</td><td>512 × 512 px (persegi)</td><td>512 KB</td><td>PNG, ICO, SVG</td></tr>
                </tbody>
            </table>
            <div class="guide-tip"><strong>Foto dari HP biasanya 3–8 MB.</strong> Perkecil dulu sebelum diunggah, misalnya dengan <a href="https://squoosh.app" target="_blank" rel="noopener">squoosh.app</a> atau <a href="https://tinypng.com" target="_blank" rel="noopener">tinypng.com</a>. Website juga jadi lebih cepat dibuka.</div>

            <h6>Ikon</h6>
            <p>Beberapa menu (Statistik, Fitur, Akses Cepat, CP Lembaga) punya kolom <strong>Icon</strong>. Isi dengan nama ikon dari <a href="https://icons.getbootstrap.com" target="_blank" rel="noopener">icons.getbootstrap.com</a> dengan awalan <code>bi bi-</code>. Contoh:</p>
            <p>
                <code>bi bi-people</code> <i class="bi bi-people"></i> &nbsp;
                <code>bi bi-trophy</code> <i class="bi bi-trophy"></i> &nbsp;
                <code>bi bi-book</code> <i class="bi bi-book"></i> &nbsp;
                <code>bi bi-whatsapp</code> <i class="bi bi-whatsapp"></i> &nbsp;
                <code>bi bi-calendar3</code> <i class="bi bi-calendar3"></i>
            </p>

            <h6>Menulis link</h6>
            <ul>
                <li><strong>Halaman di website ini:</strong> awali dengan garis miring, misalnya <code>/berita</code>, <code>/galeri</code>, <code>/download</code>, <code>/kontak</code>, <code>/program</code>.</li>
                <li><strong>Website lain:</strong> tulis alamat lengkap, misalnya <code>https://kemenag.go.id</code>.</li>
            </ul>
        </x-admin.guide-section>

        {{-- ================================================================ TAMPILAN --}}
        <x-admin.guide-section id="pengaturan" title="Pengaturan Website" icon="bi bi-gear"
            :admin="route('admin.site-settings.index')" :public="route('home')"
            where="seluruh website: judul tab browser, logo, kaki halaman (footer), warna.">
            <table class="table table-bordered">
                <tbody>
                    <tr><th style="width:24%">Tab Umum</th><td>Nama sekolah, tagline, deskripsi singkat, logo, favicon, email, telepon, alamat, link media sosial (alamat lengkap <code>https://…</code>), serta judul & deskripsi untuk Google (SEO).</td></tr>
                    <tr><th>Tab Warna Website</th><td>Pilih <em>Preset Tema</em> (default, hijau, merah, oranye) atau atur warna satu per satu: warna utama, tombol, header, footer, dan lain-lain. Tombol <em>Reset Tema</em> mengembalikan warna bawaan.</td></tr>
                    <tr><th>Tab Warna Admin</th><td>Warna sidebar dan header halaman admin.</td></tr>
                    <tr><th>Tab Ubah Password</th><td>Masukkan password lama, lalu password baru (minimal 8 karakter) dua kali.</td></tr>
                </tbody>
            </table>
            <div class="guide-tip">Halaman <strong>Tentang Kami</strong> (<code>/tentang-kami</code>) diambil dari tab Umum: logo, nama, tagline, dan <strong>deskripsi singkat</strong>. Deskripsi juga tampil di beranda dan hasil pencarian Google, jadi tulis 2–3 kalimat yang jelas.</div>
            <div class="guide-warn"><strong>Ganti warna sedikit demi sedikit.</strong> Simpan, lalu cek tampilan website. Pastikan tulisan tetap mudah dibaca di atas warna latar.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="slider" title="Slider" icon="bi bi-images"
            :admin="route('admin.sliders.index')" :public="route('home')"
            where="gambar besar bergantian di bagian paling atas beranda.">
            <ol>
                <li>Klik <strong>Tambah</strong>, isi <strong>Judul</strong> (tampil besar) dan <strong>Deskripsi</strong> (1 kalimat).</li>
                <li>Unggah <strong>Gambar</strong> mendatar, 1600 × 900 px, maksimal 2 MB.</li>
                <li>Opsional: <strong>Teks Tombol</strong> (mis. "Daftar Sekarang") dan <strong>Link Tombol</strong> (mis. <code>/kontak</code>).</li>
                <li>Atur <strong>Urutan</strong>, centang <strong>Aktif</strong>, lalu Simpan.</li>
            </ol>
            <div class="guide-warn">Slider dibatasi <strong>maksimal 4</strong>. Jika tombol tambah berubah menjadi "Batas Terpenuhi", hapus atau <strong>edit</strong> slider lama (ganti gambar dan judulnya).</div>
            <div class="guide-tip">Judul ditampilkan di <strong>sisi kiri</strong> gambar. Pilih foto dengan objek utama di <strong>tengah atau kanan</strong>.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="running-text" title="Running Text" icon="bi bi-text-paragraph"
            :admin="route('admin.running-texts.index')" :public="route('home')"
            where="teks berjalan di bagian paling atas website.">
            <ul>
                <li>Satu data = satu kalimat informasi singkat, misalnya "Pendaftaran siswa baru dibuka hingga 30 Maret".</li>
                <li><strong>Link</strong> opsional: pengunjung yang mengklik teks akan dibawa ke alamat tersebut.</li>
                <li>Matikan centang <strong>Aktif</strong> saat informasinya sudah tidak berlaku.</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="menu" title="Menu" icon="bi bi-list-ul"
            :admin="route('admin.menus.index')" :public="route('home')"
            where="navigasi di bagian atas website (Beranda, Tentang Kami, Berita, …).">
            <ol>
                <li><strong>Judul Menu</strong>: teks yang tampil, misalnya "Profil".</li>
                <li><strong>URL</strong>: tujuan menu, misalnya <code>/berita</code> atau alamat halaman yang Anda buat (<code>/sejarah-sekolah</code>).</li>
                <li><strong>Menu Parent</strong>: pilih menu induk untuk membuat <em>sub-menu</em> (menu bertingkat). Kosongkan untuk menu utama.</li>
                <li><strong>Target</strong>: <em>Tab Baru</em> hanya untuk link ke website lain.</li>
                <li><strong>Urutan</strong>: posisi menu dari kiri ke kanan.</li>
            </ol>
            <p>Alamat halaman bawaan: <code>/</code> beranda, <code>/tentang-kami</code>, <code>/program</code>, <code>/berita</code>, <code>/galeri</code>, <code>/download</code>, <code>/kontak</code>, <code>/announcements</code> (pengumuman), <code>/faqs</code>, <code>/testimonials</code>.</p>
            <div class="guide-tip">Batasi 6–7 menu utama. Kelompokkan sisanya sebagai sub-menu agar tampilan di HP tetap rapi.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="akses-cepat" title="Akses Cepat" icon="bi bi-lightning-charge"
            :admin="route('admin.quick-links.index')" :public="route('home')"
            where="tombol pintasan di beranda (mis. PPDB, Kalender Akademik, e-Rapor).">
            <ul>
                <li>Isi <strong>Judul</strong> dan <strong>URL</strong> (wajib). URL boleh ke halaman di website ini atau ke aplikasi lain (e-Rapor, PPDB online, dan sebagainya).</li>
                <li>Pilih salah satu: <strong>Icon</strong> atau <strong>Gambar</strong> kecil (maks. 512 KB).</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="cp-lembaga" title="CP Lembaga" icon="bi bi-whatsapp"
            :admin="route('admin.institution-contacts.index')" :public="route('home')"
            where="bagian kontak WhatsApp di beranda. Pengunjung memilih unit, lalu langsung membuka chat WhatsApp.">
            <ul>
                <li><strong>Nama</strong>: nama unit/bagian, misalnya "Admin PPDB", "Tata Usaha", "MTs", "MA".</li>
                <li><strong>Telepon</strong>: nomor WhatsApp. Boleh ditulis <code>0812…</code>, otomatis diubah ke format <code>62…</code>.</li>
                <li><strong>Contact Person</strong> dan <strong>Deskripsi</strong>: siapa yang melayani dan untuk keperluan apa.</li>
            </ul>
            <div class="guide-warn">Pastikan nomornya benar-benar aktif WhatsApp. Nonaktifkan unit yang tidak dipakai agar pengunjung tidak menghubungi nomor yang salah.</div>
        </x-admin.guide-section>

        {{-- ================================================================ KONTEN --}}
        <x-admin.guide-section id="halaman" title="Halaman" icon="bi bi-file-text"
            :admin="route('admin.pages.index')"
            where="halaman statis dengan alamat sendiri, misalnya /sejarah-sekolah atau /visi-misi.">
            <p>Gunakan untuk informasi yang jarang berubah: sejarah, visi-misi, struktur organisasi, fasilitas, biaya pendidikan.</p>
            <ol>
                <li>Isi <strong>Judul Halaman</strong> dan <strong>Konten</strong>. Gambar, tabel, dan daftar bisa disisipkan lewat editor.</li>
                <li><strong>Slug URL</strong> boleh dikosongkan; dibuat otomatis dari judul. Contoh: "Sejarah Sekolah" → <code>/sejarah-sekolah</code>.</li>
                <li>Simpan, lalu <strong>tambahkan ke Menu</strong> (URL: <code>/sejarah-sekolah</code>) agar bisa dibuka pengunjung dari navigasi.</li>
            </ol>
            <div class="guide-tip">Halaman tidak otomatis muncul di menu. Jangan lupa langkah 3.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="kategori" title="Kategori" icon="bi bi-tags"
            :admin="route('admin.categories.index')"
            where="label berwarna pada berita, galeri, dan file download.">
            <ul>
                <li>Contoh kategori: Berita, Kegiatan, Prestasi, Pengumuman, Dokumen.</li>
                <li>Pilih <strong>warna</strong> yang berbeda-beda agar mudah dikenali.</li>
                <li>Sebaiknya jangan menghapus kategori yang masih dipakai artikel. Ubah namanya saja.</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="artikel" title="Post/Artikel (Berita)" icon="bi bi-newspaper"
            :admin="route('admin.admin-posts.index')" :public="route('berita.index')"
            where="menu Berita. Artikel bertanda Featured juga tampil di beranda.">
            <ol>
                <li><strong>Judul</strong>: singkat dan jelas, misalnya "Siswa Raih Juara 1 Olimpiade Sains Kabupaten".</li>
                <li><strong>Ringkasan</strong>: 1–2 kalimat. Tampil di kartu berita dan hasil pencarian Google.</li>
                <li><strong>Konten</strong>: isi lengkap. Jawab 5W+1H: apa, siapa, kapan, di mana, mengapa, bagaimana.</li>
                <li><strong>Gambar Utama</strong>: foto paling mewakili, 1200 × 675 px, maks. 2 MB.</li>
                <li>Pilih <strong>Kategori</strong> (wajib).</li>
                <li>Centang <strong>Terbit</strong> agar tampil di website. Tanpa centang, artikel tersimpan sebagai <em>draf</em>.</li>
                <li>Centang <strong>Featured</strong> agar artikel juga tampil di beranda.</li>
            </ol>
            <div class="guide-tip">Unggah berita kegiatan maksimal 1–2 hari setelah acara, selagi masih hangat. Pengunjung (dan Google) menyukai website yang rutin diperbarui.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="galeri" title="Galeri" icon="bi bi-collection"
            :admin="route('admin.galleries.index')" :public="route('galeri.index')"
            where="menu Galeri. Satu galeri = satu album kegiatan berisi banyak foto.">
            <ol>
                <li>Isi <strong>Judul Galeri</strong> (nama kegiatan), <strong>Tanggal Acara</strong>, dan <strong>Lokasi</strong>.</li>
                <li>Pada <strong>Gambar Galeri</strong>, pilih <strong>beberapa foto sekaligus</strong>: tahan <kbd>Ctrl</kbd> (Mac: <kbd>Cmd</kbd>) sambil mengklik foto. Maks. 5 MB per foto.</li>
                <li><strong>Gambar Utama</strong>: sampul album. Jika dikosongkan, foto pertama dipakai.</li>
            </ol>
            <div class="guide-tip">Pilih 6–20 foto terbaik per kegiatan. Hindari foto buram atau yang memperlihatkan data pribadi siswa.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="program" title="Program" icon="bi bi-book"
            :admin="route('admin.admin-programs.index')" :public="route('program.index')"
            where="menu Program dan bagian program di beranda.">
            <ul>
                <li>Untuk program unggulan atau ekstrakurikuler: Tahfidz, Bilingual, Pramuka, Robotik, dan sebagainya.</li>
                <li>Kolom <strong>Durasi</strong>, <strong>Kelompok Usia</strong>, dan <strong>Biaya</strong> opsional. Kosongkan jika tidak relevan.</li>
                <li>Centang <strong>Program Unggulan</strong> agar tampil di bagian atas halaman Program (maks. 3).</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="pengumuman" title="Pengumuman" icon="bi bi-megaphone"
            :admin="route('admin.announcements.index')" :public="route('announcements.index')"
            where="bagian pengumuman di beranda dan halaman /announcements.">
            <ol>
                <li>Isi <strong>Judul</strong> dan <strong>Isi Pengumuman</strong>.</li>
                <li>Pilih <strong>Prioritas</strong>: Rendah, Normal, Tinggi, atau Penting/Mendesak.</li>
                <li><strong>Tampil mulai</strong> dan <strong>Tampil sampai</strong>: pengumuman tampil otomatis di rentang tanggal ini dan <strong>hilang sendiri</strong> setelah lewat. Kosongkan agar tampil terus.</li>
            </ol>
            <div class="guide-tip">Bedanya dengan Berita: Pengumuman bersifat singkat dan berbatas waktu (jadwal ujian, libur, rapat wali). Berita adalah cerita kegiatan yang tetap tersimpan sebagai arsip.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="download" title="Download" icon="bi bi-download"
            :admin="route('admin.downloads.index')" :public="route('download.index')"
            where="menu Download. Pengunjung bisa mengunduh file.">
            <ol>
                <li>Isi <strong>Judul File</strong>, misalnya "Kalender Akademik 2026/2027", dan <strong>Keterangan</strong> singkat.</li>
                <li>Pilih <strong>File</strong>: PDF, Word, Excel, PowerPoint, ZIP, JPG, atau PNG. Maksimal <strong>20 MB</strong>.</li>
                <li>Pilih <strong>Kategori</strong> (opsional), centang <strong>Aktif</strong>, lalu Simpan.</li>
            </ol>
            <ul>
                <li><strong>Mengganti file</strong> (misalnya revisi): buka Edit, pilih file baru. File lama otomatis terhapus. Kosongkan kolom file jika hanya ingin mengubah judul.</li>
                <li>Jumlah unduhan dihitung otomatis.</li>
            </ul>
            <div class="guide-tip">Ubah dokumen Word/Excel menjadi <strong>PDF</strong> sebelum diunggah, agar tampilannya sama di semua perangkat dan tidak bisa diubah orang lain.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="testimoni" title="Testimoni" icon="bi bi-chat-quote"
            :admin="route('admin.testimonials.index')" :public="route('testimonials.index')"
            where="bagian testimoni di beranda.">
            <ul>
                <li>Kesan dari wali siswa, alumni, atau tokoh masyarakat. Isi <strong>Nama</strong>, <strong>Posisi</strong> (mis. "Wali Siswa"), dan <strong>Testimoni</strong>.</li>
                <li><strong>Foto</strong> persegi, maksimal 2 MB. <strong>Rating</strong> 1–5 bintang.</li>
                <li>Mintalah izin sebelum menampilkan nama dan foto seseorang.</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="statistik" title="Statistik" icon="bi bi-graph-up"
            :admin="route('admin.statistics.index')" :public="route('home')"
            where="deretan angka di beranda (jumlah siswa, guru, prestasi, …).">
            <ul>
                <li><strong>Judul</strong>: "Siswa Aktif". <strong>Nilai</strong>: "480" atau "75+". Nilai boleh berisi teks.</li>
                <li>Perbarui angka setiap awal tahun pelajaran.</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="fitur" title="Fitur (Keunggulan)" icon="bi bi-star"
            :admin="route('admin.features.index')" :public="route('home')"
            where="daftar keunggulan sekolah di beranda.">
            <ul>
                <li>Contoh: "Guru Berpengalaman", "Lingkungan Islami", "Fasilitas Lengkap".</li>
                <li>Deskripsi cukup 1 kalimat. Pilih ikon yang sesuai.</li>
                <li>Idealnya 3, 4, atau 6 item agar tata letaknya seimbang.</li>
            </ul>
        </x-admin.guide-section>

        <x-admin.guide-section id="faq" title="FAQ" icon="bi bi-question-circle"
            :admin="route('admin.faqs.index')" :public="route('faqs.index')"
            where="halaman Tanya Jawab (/faqs).">
            <ul>
                <li>Kumpulkan pertanyaan yang paling sering ditanyakan lewat telepon/WhatsApp, lalu tulis jawabannya di sini.</li>
                <li>Atur <strong>Urutan</strong>: pertanyaan terpenting di nomor kecil.</li>
            </ul>
            <div class="guide-tip">FAQ yang lengkap mengurangi pertanyaan berulang ke admin.</div>
        </x-admin.guide-section>

        {{-- ================================================================ INTERAKSI --}}
        <x-admin.guide-section id="kontak" title="Kontak (pesan masuk)" icon="bi bi-envelope"
            :admin="route('admin.contacts.index')" :public="route('kontak.index')"
            where="pesan dari formulir di halaman Kontak website.">
            <ul>
                <li>Pesan baru ditandai <em>belum dibaca</em>. Buka pesan untuk membaca, lalu tandai sudah dibaca.</li>
                <li>Balas pengunjung lewat email atau nomor yang mereka cantumkan. Website tidak mengirim balasan otomatis.</li>
                <li>Pesan spam (judi, tautan mencurigakan) sebagian besar sudah disaring otomatis. Sisanya cukup dihapus.</li>
            </ul>
            <div class="guide-tip">Cek menu ini minimal 2–3 kali seminggu.</div>
        </x-admin.guide-section>

        <x-admin.guide-section id="komentar" title="Komentar" icon="bi bi-chat-dots"
            :admin="route('admin.comments.index')"
            where="di bawah artikel, setelah disetujui admin.">
            <p>Komentar pengunjung <strong>tidak langsung tampil</strong>. Komentar baru berstatus <span class="badge bg-warning text-dark">Pending</span> sampai disetujui.</p>
            <ul>
                <li><strong>Approve</strong>: komentar tampil di website.</li>
                <li><strong>Reject</strong>: komentar disembunyikan.</li>
                <li>Centang beberapa komentar sekaligus, lalu gunakan <em>Approve Selected</em>, <em>Reject Selected</em>, atau <em>Delete Selected</em>.</li>
                <li>Gunakan <em>Filter</em> untuk menampilkan komentar Pending saja.</li>
            </ul>
            <div class="guide-warn">Jangan menyetujui komentar berisi promosi, tautan, atau kata kasar.</div>
        </x-admin.guide-section>

        {{-- ================================================================ LAIN-LAIN --}}
        <x-admin.guide-section id="rutinitas" title="Rutinitas admin" icon="bi bi-calendar-check">
            <div class="row">
                <div class="col-md-4">
                    <h6>Setiap minggu</h6>
                    <ul>
                        <li>Cek pesan <strong>Kontak</strong> dan <strong>Komentar</strong> pending.</li>
                        <li>Unggah berita/galeri kegiatan terbaru.</li>
                        <li>Perbarui <strong>Running Text</strong> bila ada info baru.</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Setiap bulan</h6>
                    <ul>
                        <li>Nonaktifkan pengumuman dan slider yang sudah lewat.</li>
                        <li>Cek semua nomor <strong>CP Lembaga</strong> masih aktif.</li>
                        <li>Buka website dari HP: pastikan tampilan rapi.</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Setiap tahun pelajaran</h6>
                    <ul>
                        <li>Perbarui <strong>Statistik</strong>, kalender akademik, dan brosur PPDB di <strong>Download</strong>.</li>
                        <li>Ganti slider dengan foto terbaru.</li>
                        <li>Ganti password admin.</li>
                    </ul>
                </div>
            </div>
        </x-admin.guide-section>

        <x-admin.guide-section id="masalah" title="Masalah umum & solusi" icon="bi bi-life-preserver">
            <table class="table table-bordered">
                <thead class="table-light"><tr><th style="width:38%">Masalah</th><th>Solusi</th></tr></thead>
                <tbody>
                    <tr><td>Gambar gagal diunggah / muncul pesan ukuran terlalu besar</td><td>Perkecil foto (lihat <a href="#gambar">Gambar, ikon & link</a>). Pastikan formatnya JPG atau PNG.</td></tr>
                    <tr><td>Data sudah disimpan tetapi tidak muncul di website</td><td>Pastikan centang <strong>Aktif</strong> / <strong>Terbit</strong>. Untuk pengumuman, cek tanggal <em>Tampil mulai/sampai</em>. Muat ulang halaman website (<kbd>Ctrl</kbd>+<kbd>F5</kbd>).</td></tr>
                    <tr><td>Artikel tidak tampil di beranda</td><td>Centang <strong>Featured</strong> pada artikel tersebut.</td></tr>
                    <tr><td>Halaman baru tidak ada di navigasi</td><td>Tambahkan lewat menu <a href="#menu">Menu</a>.</td></tr>
                    <tr><td>Pesan "Link harus diawali /…"</td><td>Tulis <code>/berita</code> untuk halaman website ini, atau <code>https://…</code> untuk website lain.</td></tr>
                    <tr><td>Tampilan berantakan setelah ganti warna</td><td>Pengaturan Website → tab Warna Website → <em>Reset</em>.</td></tr>
                    <tr><td>Komentar pengunjung tidak muncul</td><td>Komentar perlu disetujui dulu di menu <a href="#komentar">Komentar</a>.</td></tr>
                    <tr><td>Login dikunci / "Too many attempts"</td><td>Tunggu 1 menit lalu coba lagi dengan password yang benar.</td></tr>
                    <tr><td>Lupa password admin</td><td>Hubungi pengelola server/teknis untuk mengatur ulang password.</td></tr>
                    <tr><td>Muncul halaman error (500) atau website tidak bisa dibuka</td><td>Catat waktu dan langkah yang dilakukan, ambil tangkapan layar, lalu hubungi pengelola teknis.</td></tr>
                </tbody>
            </table>
        </x-admin.guide-section>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('guideSearch');
    const sections = Array.from(document.querySelectorAll('[data-guide-section]'));
    const noResult = document.getElementById('guideNoResult');

    input.addEventListener('input', function () {
        const q = input.value.trim().toLowerCase();
        let visible = 0;
        sections.forEach(function (section) {
            const match = !q || section.textContent.toLowerCase().includes(q);
            section.classList.toggle('d-none', !match);
            const link = document.querySelector('[data-toc-for="' + section.id + '"]');
            if (link) link.classList.toggle('d-none', !match);
            if (match) visible++;
        });
        noResult.classList.toggle('d-none', visible > 0);
    });
});
</script>
@endpush
