<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Download;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\InstitutionContact;
use App\Models\Page;
use App\Models\Post;
use App\Models\Program;
use App\Models\QuickLink;
use App\Models\RunningText;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\Statistic;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalDemoContentSeeder extends Seeder
{
    private array $palette = [
        ['#12664f', '#dda937', '#ffffff'],
        ['#1d4ed8', '#f97316', '#ffffff'],
        ['#0f766e', '#facc15', '#ffffff'],
        ['#7c2d12', '#22c55e', '#ffffff'],
        ['#312e81', '#06b6d4', '#ffffff'],
        ['#9f1239', '#f59e0b', '#ffffff'],
    ];

    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@webdemo.test'],
            ['name' => 'Administrator', 'password' => Hash::make('password')]
        );

        $this->ensureStorageAssets();
        $this->seedCategories();
        $this->seedSiteLogo();
        $this->seedSliders();
        $this->seedRunningTexts();
        $this->seedPages();
        $this->seedPrograms();
        $this->seedPosts($admin);
        $this->seedGalleries();
        $this->seedAnnouncements();
        $this->seedDownloads();
        $this->seedFaqs();
        $this->seedTestimonials();
        $this->seedHomeSupportContent();
        $this->seedInstitutionContacts();
    }

    private function ensureStorageAssets(): void
    {
        $assets = [
            'demo/logos/web-demo-logo.png' => 'Web Demo',
            'demo/favicons/web-demo-favicon.png' => 'WD',
            'demo/sliders/gerbang-demo.png' => 'Gerbang Demo',
            'demo/sliders/kegiatan-belajar.png' => 'Kegiatan Belajar',
            'demo/sliders/tahfidz-prestasi.png' => 'Tahfidz Prestasi',
            'demo/sliders/lab-komputer.png' => 'Lab Komputer',
            'demo/posts/ppdb.png' => 'PPDB',
            'demo/posts/prestasi-santri.png' => 'Prestasi Santri',
            'demo/posts/kelas-inspirasi.png' => 'Kelas Inspirasi',
            'demo/posts/bakti-sosial.png' => 'Bakti Sosial',
            'demo/posts/pelatihan-guru.png' => 'Pelatihan Guru',
            'demo/posts/perpustakaan.png' => 'Perpustakaan',
            'demo/programs/tahfidz.png' => 'Tahfidz',
            'demo/programs/bilingual.png' => 'Bilingual',
            'demo/programs/digital.png' => 'Digital',
            'demo/programs/karakter.png' => 'Karakter',
            'demo/galleries/upacara.png' => 'Upacara',
            'demo/galleries/olahraga.png' => 'Olahraga',
            'demo/galleries/pramuka.png' => 'Pramuka',
            'demo/galleries/kelas.png' => 'Kelas',
            'demo/testimonials/wali-1.png' => 'Wali Siswa',
            'demo/testimonials/alumni-1.png' => 'Alumni',
            'demo/testimonials/guru-1.png' => 'Guru',
            'demo/quick-links/ppdb.png' => 'Daftar',
            'demo/quick-links/kalender.png' => 'Kalender',
        ];

        foreach ($assets as $path => $label) {
            $this->makeImage($path, $label);
        }

        Storage::disk('public')->put('demo/downloads/brosur-ppdb.pdf', $this->minimalPdf('Brosur PPDB Web Demo Pendidikan'));
        Storage::disk('public')->put('demo/downloads/kalender-akademik.pdf', $this->minimalPdf('Kalender Akademik Web Demo Pendidikan'));
        Storage::disk('public')->put('demo/downloads/formulir-pendaftaran.pdf', $this->minimalPdf('Formulir Pendaftaran Web Demo Pendidikan'));
    }

    private function makeImage(string $path, string $label): void
    {
        $fullPath = storage_path('app/public/' . $path);
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0775, true);
        }

        $index = abs(crc32($path)) % count($this->palette);
        [$primary, $accent, $text] = $this->palette[$index];
        $width = str_contains($path, 'logo') || str_contains($path, 'favicon') ? 600 : 1280;
        $height = str_contains($path, 'logo') || str_contains($path, 'favicon') ? 600 : 720;
        $image = imagecreatetruecolor($width, $height);
        $primaryRgb = $this->hexToRgb($primary);
        $accentRgb = $this->hexToRgb($accent);
        $textRgb = $this->hexToRgb($text);

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / max(1, $height - 1);
            $r = (int) ($primaryRgb[0] * (1 - $ratio) + $accentRgb[0] * $ratio);
            $g = (int) ($primaryRgb[1] * (1 - $ratio) + $accentRgb[1] * $ratio);
            $b = (int) ($primaryRgb[2] * (1 - $ratio) + $accentRgb[2] * $ratio);
            imageline($image, 0, $y, $width, $y, imagecolorallocate($image, $r, $g, $b));
        }

        $white = imagecolorallocate($image, $textRgb[0], $textRgb[1], $textRgb[2]);
        $darkOverlay = imagecolorallocatealpha($image, 0, 0, 0, 80);
        imagefilledrectangle($image, 0, 0, $width, $height, $darkOverlay);

        $font = 5;
        $line1 = 'Web Demo Pendidikan';
        $line2 = Str::limit($label, 32, '');
        imagestring($image, $font, 54, (int) ($height / 2) - 28, $line1, $white);
        imagestring($image, $font, 54, (int) ($height / 2) + 4, $line2, $white);

        imagepng($image, $fullPath);
        imagedestroy($image);
    }

    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    private function minimalPdf(string $title): string
    {
        return "%PDF-1.1\n1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n"
            . "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n"
            . "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R >> endobj\n"
            . "4 0 obj << /Length 62 >> stream\nBT /F1 18 Tf 72 720 Td (" . $title . ") Tj ET\nendstream endobj\n"
            . "xref\n0 5\n0000000000 65535 f \ntrailer << /Root 1 0 R /Size 5 >>\nstartxref\n260\n%%EOF";
    }

    private function seedCategories(): void
    {
        $categories = [
            ['name' => 'Berita', 'slug' => 'berita', 'description' => 'Berita terbaru yayasan dan unit pendidikan', 'color' => '#12664f'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'description' => 'Dokumentasi kegiatan siswa dan guru', 'color' => '#dda937'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Prestasi akademik dan non-akademik', 'color' => '#1d4ed8'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Informasi resmi untuk wali siswa', 'color' => '#bd5444'],
            ['name' => 'Galeri', 'slug' => 'galeri', 'description' => 'Kumpulan foto kegiatan', 'color' => '#0f766e'],
            ['name' => 'Dokumen', 'slug' => 'dokumen', 'description' => 'Berkas unduhan sekolah', 'color' => '#64748b'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category + ['is_active' => true]);
        }
    }

    private function seedSiteLogo(): void
    {
        $settings = SiteSetting::first();
        if (!$settings) {
            SiteSetting::create([
                'site_name' => 'Web Demo Pendidikan',
                'site_tagline' => 'Template website sekolah dan yayasan siap pakai',
                'site_description' => 'Website demo pendidikan yang siap disesuaikan untuk profil lembaga, berita, galeri, download, dan layanan informasi.',
                'logo' => 'demo/logos/web-demo-logo.png',
                'favicon' => 'demo/favicons/web-demo-favicon.png',
                'email' => 'admin@webdemo.test',
                'phone' => '081234567890',
                'address' => 'Jl. Demo Pendidikan No. 1, Kota Demo',
            ]);

            return;
        }

        $settings->forceFill([
            'site_name' => 'Web Demo Pendidikan',
            'site_tagline' => 'Template website sekolah dan yayasan siap pakai',
            'site_description' => 'Website demo pendidikan yang siap disesuaikan untuk profil lembaga, berita, galeri, download, dan layanan informasi.',
            'logo' => 'demo/logos/web-demo-logo.png',
            'favicon' => 'demo/favicons/web-demo-favicon.png',
            'email' => 'admin@webdemo.test',
            'phone' => '081234567890',
            'address' => 'Jl. Demo Pendidikan No. 1, Kota Demo',
            'facebook' => 'https://example.com/webdemo-facebook',
            'instagram' => 'https://example.com/webdemo-instagram',
            'youtube' => 'https://example.com/webdemo-youtube',
            'meta_title' => 'Web Demo Pendidikan - Website Sekolah Siap Pakai',
            'meta_description' => 'Website demo pendidikan yang siap disesuaikan untuk profil lembaga, berita, galeri, download, dan layanan informasi.',
            'meta_keywords' => 'web demo, pendidikan, sekolah, yayasan, berita, galeri, download',
        ])->save();
    }

    private function seedSliders(): void
    {
        $sliders = [
            ['title' => 'Website Demo Pendidikan Siap Dipakai', 'description' => 'Tampilan profil, program, berita, galeri, download, dan kontak sudah terisi data contoh.', 'image' => 'demo/sliders/gerbang-demo.png', 'button_text' => 'Lihat Program', 'button_link' => '/programs'],
            ['title' => 'Kegiatan Belajar Aktif dan Terarah', 'description' => 'Siswa bertumbuh melalui pembelajaran kelas, proyek, dan pembiasaan karakter.', 'image' => 'demo/sliders/kegiatan-belajar.png', 'button_text' => 'Baca Berita', 'button_link' => '/posts'],
            ['title' => 'Tahfidz dan Prestasi Berjalan Seimbang', 'description' => 'Pembinaan Al-Quran, akademik, dan minat bakat disiapkan secara bertahap.', 'image' => 'demo/sliders/tahfidz-prestasi.png', 'button_text' => 'Daftar PPDB', 'button_link' => '/contact'],
            ['title' => 'Keterampilan Digital untuk Masa Depan', 'description' => 'Fasilitas belajar mendukung literasi teknologi dan kreativitas siswa.', 'image' => 'demo/sliders/lab-komputer.png', 'button_text' => 'Lihat Galeri', 'button_link' => '/galleries'],
        ];

        foreach ($sliders as $index => $slider) {
            Slider::updateOrCreate(['title' => $slider['title']], $slider + ['order' => $index + 1, 'is_active' => true]);
        }
    }

    private function seedRunningTexts(): void
    {
        $texts = [
            ['text' => 'PPDB Web Demo Pendidikan tahun ajaran baru telah dibuka. Hubungi admin untuk jadwal observasi.', 'link' => '/contact'],
            ['text' => 'Simak berita kegiatan siswa terbaru melalui menu Berita dan Galeri.', 'link' => '/posts'],
            ['text' => 'Unduh kalender akademik dan formulir pendaftaran di menu Download.', 'link' => '/downloads'],
        ];

        foreach ($texts as $index => $text) {
            RunningText::updateOrCreate(['text' => $text['text']], $text + ['order' => $index + 1, 'is_active' => true]);
        }
    }

    private function seedPages(): void
    {
        $pages = [
            ['title' => 'Tentang Kami', 'slug' => 'tentang-kami'],
            ['title' => 'Profil Yayasan', 'slug' => 'profil-yayasan'],
            ['title' => 'Visi dan Misi', 'slug' => 'visi-misi'],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], [
                'title' => $page['title'],
                'content' => '<h2>' . e($page['title']) . '</h2><p>Web Demo Pendidikan berkomitmen membangun layanan pendidikan Islam yang tertib, ramah, dan relevan dengan kebutuhan keluarga masa kini.</p><p>Konten ini adalah data contoh untuk pengisian lokal dan dapat diedit dari halaman admin.</p>',
                'meta_title' => $page['title'] . ' - Web Demo Pendidikan',
                'meta_description' => 'Informasi ' . strtolower($page['title']) . ' Web Demo Pendidikan.',
                'is_active' => true,
            ]);
        }
    }

    private function seedPrograms(): void
    {
        $programs = [
            ['title' => 'Tahfidz dan Pembiasaan Ibadah', 'image' => 'demo/programs/tahfidz.png', 'icon' => 'bi bi-book', 'duration' => 'Setiap pekan', 'age_group' => 'Semua jenjang'],
            ['title' => 'Kelas Bilingual Dasar', 'image' => 'demo/programs/bilingual.png', 'icon' => 'bi bi-translate', 'duration' => '2 semester', 'age_group' => 'SMP - SMA'],
            ['title' => 'Literasi Digital dan Komputer', 'image' => 'demo/programs/digital.png', 'icon' => 'bi bi-laptop', 'duration' => '1 semester', 'age_group' => 'SMP - SMK'],
            ['title' => 'Penguatan Karakter dan Kepemimpinan', 'image' => 'demo/programs/karakter.png', 'icon' => 'bi bi-compass', 'duration' => 'Berkelanjutan', 'age_group' => 'Semua jenjang'],
        ];

        foreach ($programs as $index => $program) {
            Program::updateOrCreate(['slug' => Str::slug($program['title'])], [
                'title' => $program['title'],
                'excerpt' => 'Program contoh untuk memperkaya halaman publik dan admin lokal.',
                'content' => '<p>Program ini dirancang untuk membantu siswa tumbuh secara akademik, spiritual, dan sosial.</p><ul><li>Pendampingan guru</li><li>Target terukur</li><li>Evaluasi berkala</li></ul>',
                'featured_image' => $program['image'],
                'icon' => $program['icon'],
                'duration' => $program['duration'],
                'age_group' => $program['age_group'],
                'price' => null,
                'is_featured' => $index < 2,
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }
    }

    private function seedPosts(User $admin): void
    {
        $categoryIds = Category::pluck('id', 'slug');
        $posts = [
            ['title' => 'PPDB Web Demo Pendidikan Dibuka dengan Layanan Konsultasi Orang Tua', 'category' => 'berita', 'image' => 'demo/posts/ppdb.png'],
            ['title' => 'Siswa Demo Raih Prestasi Lomba Akademik Tingkat Kabupaten', 'category' => 'prestasi', 'image' => 'demo/posts/prestasi-santri.png'],
            ['title' => 'Kelas Inspirasi Mengenalkan Profesi dan Adab Bekerja', 'category' => 'kegiatan', 'image' => 'demo/posts/kelas-inspirasi.png'],
            ['title' => 'Bakti Sosial Melatih Kepedulian Siswa kepada Lingkungan', 'category' => 'kegiatan', 'image' => 'demo/posts/bakti-sosial.png'],
            ['title' => 'Pelatihan Guru Menguatkan Pembelajaran Berbasis Proyek', 'category' => 'berita', 'image' => 'demo/posts/pelatihan-guru.png'],
            ['title' => 'Perpustakaan Sekolah Diperbarui untuk Budaya Literasi', 'category' => 'berita', 'image' => 'demo/posts/perpustakaan.png'],
        ];

        foreach ($posts as $index => $post) {
            Post::updateOrCreate(['slug' => Str::slug($post['title'])], [
                'title' => $post['title'],
                'excerpt' => 'Ringkasan artikel contoh untuk mengisi halaman berita lokal Web Demo Pendidikan.',
                'content' => '<p>Artikel ini merupakan konten contoh untuk melihat tampilan halaman berita, kartu artikel, dan detail berita.</p><p>Admin dapat mengganti judul, foto, isi artikel, kategori, dan status publikasi kapan saja dari dashboard.</p>',
                'featured_image' => $post['image'],
                'category_id' => $categoryIds[$post['category']] ?? Category::first()->id,
                'user_id' => $admin->id,
                'meta_title' => $post['title'],
                'meta_description' => 'Artikel contoh Web Demo Pendidikan.',
                'is_published' => true,
                'is_featured' => $index < 3,
                'views' => rand(35, 420),
                'published_at' => now()->subDays($index),
            ]);
        }
    }

    private function seedGalleries(): void
    {
        $categoryId = Category::where('slug', 'galeri')->value('id');
        $galleries = [
            ['title' => 'Upacara dan Pembiasaan Pagi', 'image' => 'demo/galleries/upacara.png', 'location' => 'Halaman Demo'],
            ['title' => 'Kegiatan Olahraga dan Kesehatan', 'image' => 'demo/galleries/olahraga.png', 'location' => 'Lapangan Sekolah'],
            ['title' => 'Latihan Pramuka dan Kepemimpinan', 'image' => 'demo/galleries/pramuka.png', 'location' => 'Area Sekolah'],
            ['title' => 'Suasana Belajar di Kelas', 'image' => 'demo/galleries/kelas.png', 'location' => 'Ruang Kelas'],
        ];

        foreach ($galleries as $index => $gallery) {
            Gallery::updateOrCreate(['slug' => Str::slug($gallery['title'])], [
                'title' => $gallery['title'],
                'description' => 'Foto dokumentasi contoh untuk mengisi galeri lokal.',
                'content' => '<p>Galeri ini berisi dokumentasi contoh kegiatan siswa Web Demo Pendidikan.</p>',
                'image' => $gallery['image'],
                'featured_image' => $gallery['image'],
                'thumbnail' => $gallery['image'],
                'type' => 'image',
                'category_id' => $categoryId,
                'event_date' => now()->subDays($index + 3),
                'location' => $gallery['location'],
                'is_featured' => $index < 2,
                'order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedAnnouncements(): void
    {
        $announcements = [
            ['title' => 'Jadwal Observasi dan Wawancara PPDB Gelombang Pertama', 'priority' => 'high'],
            ['title' => 'Pengambilan Seragam dan Kitab Panduan Siswa Baru', 'priority' => 'normal'],
            ['title' => 'Rapat Wali Siswa Awal Tahun Pelajaran', 'priority' => 'urgent'],
        ];

        foreach ($announcements as $index => $announcement) {
            Announcement::updateOrCreate(['slug' => Str::slug($announcement['title'])], [
                'title' => $announcement['title'],
                'content' => '<p>Pengumuman contoh ini dapat diedit dari admin. Silakan sesuaikan tanggal, prioritas, dan isi pengumuman sesuai kebutuhan.</p>',
                'priority' => $announcement['priority'],
                'is_active' => true,
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(30 + $index),
            ]);
        }
    }

    private function seedDownloads(): void
    {
        $categoryId = Category::where('slug', 'dokumen')->value('id');
        $downloads = [
            ['title' => 'Brosur PPDB Web Demo Pendidikan', 'file' => 'demo/downloads/brosur-ppdb.pdf'],
            ['title' => 'Kalender Akademik Tahun Pelajaran', 'file' => 'demo/downloads/kalender-akademik.pdf'],
            ['title' => 'Formulir Pendaftaran Siswa Baru', 'file' => 'demo/downloads/formulir-pendaftaran.pdf'],
        ];

        foreach ($downloads as $download) {
            Download::updateOrCreate(['title' => $download['title']], [
                'description' => 'Dokumen contoh untuk menu download lokal.',
                'file_path' => $download['file'],
                'file_name' => basename($download['file']),
                'file_type' => 'pdf',
                'file_size' => Storage::disk('public')->size($download['file']),
                'category_id' => $categoryId,
                'download_count' => rand(10, 120),
                'is_active' => true,
            ]);
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            ['question' => 'Bagaimana cara mendaftar siswa baru?', 'answer' => 'Pendaftaran dapat dilakukan melalui kontak admin atau datang langsung ke kantor Web Demo Pendidikan dengan membawa dokumen dasar calon siswa.'],
            ['question' => 'Apakah tersedia konsultasi pilihan jenjang?', 'answer' => 'Ya, wali siswa dapat berkonsultasi dengan admin PPDB untuk memilih jenjang dan program yang sesuai.'],
            ['question' => 'Dokumen apa saja yang perlu disiapkan?', 'answer' => 'Dokumen umum meliputi akta kelahiran, kartu keluarga, pas foto, rapor terakhir, dan dokumen pendukung lain sesuai jenjang.'],
            ['question' => 'Di mana informasi terbaru bisa dilihat?', 'answer' => 'Informasi terbaru tersedia melalui halaman Berita, Pengumuman, Download, dan kontak resmi yayasan.'],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], [
                'answer' => '<p>' . e($faq['answer']) . '</p>',
                'order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            ['name' => 'Ibu Nur Aini', 'position' => 'Wali Siswa', 'company' => 'SMP', 'photo' => 'demo/testimonials/wali-1.png'],
            ['name' => 'Ahmad Fikri', 'position' => 'Alumni', 'company' => 'Angkatan 2023', 'photo' => 'demo/testimonials/alumni-1.png'],
            ['name' => 'Ustadzah Laila', 'position' => 'Guru Pendamping', 'company' => 'Demo', 'photo' => 'demo/testimonials/guru-1.png'],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::updateOrCreate(['name' => $testimonial['name']], [
                'position' => $testimonial['position'],
                'company' => $testimonial['company'],
                'testimonial' => 'Konten contoh: lingkungan belajar Demo terasa tertib, komunikatif, dan membantu siswa bertumbuh dengan nilai Islam.',
                'photo' => $testimonial['photo'],
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }
    }

    private function seedHomeSupportContent(): void
    {
        $features = [
            ['title' => 'Pembiasaan Adab', 'description' => 'Rutinitas harian membantu siswa membangun sikap santun dan disiplin.', 'icon' => 'bi bi-heart'],
            ['title' => 'Guru Pendamping', 'description' => 'Pendampingan belajar dilakukan dengan komunikasi yang dekat dengan wali siswa.', 'icon' => 'bi bi-people'],
            ['title' => 'Kegiatan Terarah', 'description' => 'Agenda akademik dan non-akademik disusun untuk menguatkan potensi siswa.', 'icon' => 'bi bi-calendar-check'],
            ['title' => 'Lingkungan Aman', 'description' => 'Suasana sekolah mendukung belajar, ibadah, dan interaksi sosial yang sehat.', 'icon' => 'bi bi-shield-check'],
        ];

        foreach ($features as $index => $feature) {
            Feature::updateOrCreate(['title' => $feature['title']], $feature + ['order' => $index + 1, 'is_active' => true]);
        }

        $statistics = [
            ['title' => 'Siswa Aktif', 'value' => '850+', 'icon' => 'bi bi-mortarboard', 'description' => 'Data contoh untuk tampilan statistik'],
            ['title' => 'Guru dan Tendik', 'value' => '75+', 'icon' => 'bi bi-person-badge', 'description' => 'Data contoh untuk tampilan statistik'],
            ['title' => 'Program Unggulan', 'value' => '12', 'icon' => 'bi bi-stars', 'description' => 'Data contoh untuk tampilan statistik'],
            ['title' => 'Tahun Mengabdi', 'value' => '25+', 'icon' => 'bi bi-building', 'description' => 'Data contoh untuk tampilan statistik'],
        ];

        foreach ($statistics as $index => $statistic) {
            Statistic::updateOrCreate(['title' => $statistic['title']], $statistic + ['order' => $index + 1, 'is_active' => true]);
        }

        $quickLinks = [
            ['title' => 'Daftar PPDB', 'url' => '/contact', 'icon' => 'bi bi-pencil-square', 'image' => 'demo/quick-links/ppdb.png'],
            ['title' => 'Kalender Akademik', 'url' => '/downloads', 'icon' => 'bi bi-calendar3', 'image' => 'demo/quick-links/kalender.png'],
            ['title' => 'Berita Terbaru', 'url' => '/posts', 'icon' => 'bi bi-newspaper', 'image' => null],
            ['title' => 'Galeri Kegiatan', 'url' => '/galleries', 'icon' => 'bi bi-images', 'image' => null],
        ];

        foreach ($quickLinks as $index => $link) {
            QuickLink::updateOrCreate(['title' => $link['title']], $link + ['order' => $index + 1, 'is_active' => true]);
        }
    }

    private function seedInstitutionContacts(): void
    {
        $contacts = [
            ['name' => 'Yayasan', 'contact_person' => 'Admin Yayasan', 'phone' => '081234567890', 'description' => 'Informasi umum dan kemitraan'],
            ['name' => 'MTs', 'contact_person' => 'Admin MTs', 'phone' => '081234567890', 'description' => 'Informasi jenjang madrasah tsanawiyah'],
            ['name' => 'SMP', 'contact_person' => 'Admin SMP', 'phone' => '081234567890', 'description' => 'Informasi jenjang sekolah menengah pertama'],
            ['name' => 'MA', 'contact_person' => 'Admin MA', 'phone' => '081234567890', 'description' => 'Informasi jenjang madrasah aliyah'],
            ['name' => 'SMA', 'contact_person' => 'Admin SMA', 'phone' => '081234567890', 'description' => 'Informasi jenjang sekolah menengah atas'],
            ['name' => 'SMK', 'contact_person' => 'Admin SMK', 'phone' => '081234567890', 'description' => 'Informasi jenjang sekolah menengah kejuruan'],
        ];

        foreach ($contacts as $index => $contact) {
            InstitutionContact::updateOrCreate(['name' => $contact['name']], $contact + [
                'icon' => 'bi bi-whatsapp',
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
