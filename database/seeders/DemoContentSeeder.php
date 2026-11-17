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
use App\Models\Slider;
use App\Models\Statistic;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Data dummy lengkap (teks + gambar + PDF) sebagai gambaran cara mengisi website.
 *
 *   php artisan db:seed --class=DemoContentSeeder --force
 *
 * - Aman dijalankan berulang: data dicocokkan lewat slug/judul, tidak dobel.
 * - Tidak mengubah akun admin maupun identitas situs (Site Settings).
 * - Gambar diambil dari database/seeders/demo-assets dan disalin ke storage/app/public/demo.
 * - Gambar yang hilang pada data lama (mis. dari SampleDataSeeder) diganti gambar contoh.
 *
 * Hapus semua data dummy: php artisan db:seed --class=DemoContentCleanupSeeder --force
 */
class DemoContentSeeder extends Seeder
{
    public const STORAGE_DIR = 'demo';

    private const NOTE = '<p class="text-muted"><em>Ini adalah konten contoh untuk gambaran pengisian website. Silakan ubah atau hapus melalui halaman admin.</em></p>';

    public function run(): void
    {
        $this->copyAssets();

        $categories = $this->seedCategories();
        $this->seedSliders();
        $this->seedRunningTexts();
        $this->seedPosts($categories);
        $this->seedPrograms();
        $this->seedGalleries($categories);
        $this->seedAnnouncements();
        $this->seedDownloads($categories);
        $this->seedTestimonials();
        $this->seedFaqs();
        $this->seedHomeSections();
        $this->seedInstitutionContacts();
        $this->seedPage();
        $this->repairMissingImages();

        $this->command?->info('Data dummy selesai dibuat. Gambar ada di storage/app/public/' . self::STORAGE_DIR . '.');
    }

    /* ------------------------------------------------------------------ */
    /*  Data                                                               */
    /* ------------------------------------------------------------------ */

    public static function sliders(): array
    {
        return [
            ['title' => 'Belajar, Beribadah, dan Berprestasi', 'description' => 'Lingkungan sekolah yang tertib, ramah, dan menumbuhkan karakter islami setiap hari.', 'image' => 'sliders/gedung-sekolah.jpg', 'button_text' => 'Kenali Kami', 'button_link' => '/tentang-kami'],
            ['title' => 'Kegiatan Belajar Aktif dan Menyenangkan', 'description' => 'Pembelajaran di kelas, proyek, dan diskusi membantu siswa berpikir kritis dan kreatif.', 'image' => 'sliders/kegiatan-belajar.jpg', 'button_text' => 'Baca Berita', 'button_link' => '/berita'],
            ['title' => 'Program Tahfidz Al-Qur\'an', 'description' => 'Target hafalan bertahap dengan pendampingan guru tahfidz dan setoran rutin.', 'image' => 'sliders/tahfidz.jpg', 'button_text' => 'Lihat Program', 'button_link' => '/program'],
            ['title' => 'Siap Menghadapi Era Digital', 'description' => 'Laboratorium komputer dan literasi digital untuk membekali keterampilan masa depan.', 'image' => 'sliders/lab-komputer.jpg', 'button_text' => 'Lihat Galeri', 'button_link' => '/galeri'],
        ];
    }

    public static function posts(): array
    {
        return [
            [
                'title' => 'Pendaftaran Peserta Didik Baru Resmi Dibuka',
                'category' => 'berita', 'image' => 'posts/ppdb.jpg', 'featured' => true,
                'excerpt' => 'Pendaftaran peserta didik baru dibuka dalam dua gelombang. Calon wali siswa dapat berkonsultasi langsung dengan panitia.',
                'content' => '<p>Sekolah membuka Penerimaan Peserta Didik Baru (PPDB) untuk tahun pelajaran mendatang. Pendaftaran dibagi menjadi dua gelombang agar keluarga memiliki waktu yang cukup untuk menyiapkan berkas.</p>'
                    . '<h3>Alur pendaftaran</h3><ol><li>Mengisi formulir pendaftaran (tersedia di menu Download).</li><li>Menyerahkan berkas persyaratan ke kantor sekolah.</li><li>Mengikuti tes dasar dan wawancara bersama orang tua.</li><li>Pengumuman hasil seleksi melalui website dan WhatsApp.</li></ol>'
                    . '<p>Panitia juga membuka layanan konsultasi bagi orang tua yang ingin mengetahui program unggulan, kegiatan harian, maupun biaya pendidikan.</p>'
                    . '<blockquote>"Kami ingin setiap keluarga merasa yakin dan nyaman sejak hari pertama mendaftar," ujar ketua panitia PPDB.</blockquote>',
            ],
            [
                'title' => 'Siswa Raih Juara Olimpiade Sains Tingkat Kabupaten',
                'category' => 'prestasi', 'image' => 'posts/prestasi.jpg', 'featured' => true,
                'excerpt' => 'Tiga siswa berhasil membawa pulang medali pada olimpiade sains tingkat kabupaten setelah tiga bulan pembinaan.',
                'content' => '<p>Kabar membanggakan datang dari ajang Olimpiade Sains tingkat kabupaten. Tiga siswa berhasil meraih juara 1, 2, dan 3 pada bidang Matematika dan IPA.</p>'
                    . '<p>Keberhasilan ini merupakan hasil pembinaan rutin selama tiga bulan yang dilaksanakan setiap pulang sekolah. Para siswa dibimbing untuk memahami konsep, berlatih soal, dan membiasakan diri bekerja dengan teliti.</p>'
                    . '<figure><img src="/storage/demo/galleries/kelas-2.jpg" alt="Pembinaan olimpiade"><figcaption>Suasana pembinaan olimpiade di kelas.</figcaption></figure>'
                    . '<p>Kepala sekolah menyampaikan apresiasi kepada siswa, guru pembina, dan orang tua yang terus memberikan dukungan.</p>',
            ],
            [
                'title' => 'Kelas Inspirasi: Mengenal Profesi Sejak Dini',
                'category' => 'kegiatan', 'image' => 'posts/kelas-inspirasi.jpg', 'featured' => true,
                'excerpt' => 'Alumni dan orang tua berbagi pengalaman kerja untuk membuka wawasan siswa tentang cita-cita dan adab bekerja.',
                'content' => '<p>Kelas Inspirasi menghadirkan alumni dan orang tua siswa dari berbagai profesi: dokter, guru, pengusaha, programmer, hingga petani modern.</p>'
                    . '<p>Setiap narasumber bercerita tentang perjalanan karier, tantangan, dan nilai-nilai yang dipegang dalam bekerja. Siswa terlihat antusias bertanya dan mencatat.</p>'
                    . '<ul><li>Sesi berbagi pengalaman</li><li>Tanya jawab interaktif</li><li>Menulis surat cita-cita untuk diri sendiri 10 tahun mendatang</li></ul>',
            ],
            [
                'title' => 'Bakti Sosial: Berbagi Paket Sembako untuk Warga Sekitar',
                'category' => 'kegiatan', 'image' => 'posts/bakti-sosial.jpg', 'featured' => false,
                'excerpt' => 'OSIS bersama guru menyalurkan ratusan paket sembako hasil donasi siswa dan wali siswa.',
                'content' => '<p>Dalam rangka menumbuhkan kepedulian sosial, OSIS menyelenggarakan bakti sosial di lingkungan sekitar sekolah. Paket sembako dikumpulkan dari donasi siswa, guru, dan wali siswa selama dua pekan.</p>'
                    . '<p>Kegiatan ini juga dilengkapi dengan kerja bakti membersihkan musala dan fasilitas umum di sekitar sekolah.</p>',
            ],
            [
                'title' => 'Pelatihan Guru: Menguatkan Pembelajaran Berbasis Proyek',
                'category' => 'berita', 'image' => 'posts/pelatihan-guru.jpg', 'featured' => false,
                'excerpt' => 'Guru mengikuti workshop dua hari untuk merancang pembelajaran berbasis proyek yang relevan dengan kehidupan siswa.',
                'content' => '<p>Seluruh guru mengikuti workshop Pembelajaran Berbasis Proyek (Project Based Learning) selama dua hari. Materi meliputi perancangan proyek, asesmen autentik, dan refleksi pembelajaran.</p>'
                    . '<p>Di akhir kegiatan, setiap kelompok guru mempresentasikan rancangan proyek lintas mata pelajaran yang akan diterapkan pada semester berjalan.</p>',
            ],
            [
                'title' => 'Perpustakaan Sekolah Hadir dengan Wajah Baru',
                'category' => 'berita', 'image' => 'posts/perpustakaan.jpg', 'featured' => false,
                'excerpt' => 'Ruang baca yang lebih nyaman dan ratusan koleksi buku baru untuk menumbuhkan budaya literasi.',
                'content' => '<p>Perpustakaan sekolah kini tampil lebih nyaman dengan penataan rak baru, area baca lesehan, dan pencahayaan yang lebih baik.</p>'
                    . '<p>Ratusan judul buku baru telah ditambahkan, mulai dari buku cerita islami, ensiklopedia, hingga buku sains populer. Program "15 menit membaca" juga dilaksanakan setiap pagi sebelum pelajaran dimulai.</p>',
            ],
        ];
    }

    public static function programs(): array
    {
        return [
            ['title' => 'Tahfidz Al-Qur\'an', 'image' => 'programs/tahfidz.jpg', 'icon' => 'bi bi-book', 'duration' => 'Setiap hari', 'age_group' => 'Semua kelas',
                'excerpt' => 'Program hafalan Al-Qur\'an bertahap dengan target yang terukur dan pendampingan guru tahfidz.',
                'content' => '<p>Program tahfidz dilaksanakan setiap pagi dengan metode talaqqi dan murajaah. Setiap siswa memiliki buku mutaba\'ah untuk memantau perkembangan hafalan.</p><ul><li>Target hafalan per semester</li><li>Setoran harian kepada guru</li><li>Wisuda tahfidz di akhir tahun</li></ul>'],
            ['title' => 'Kelas Bilingual', 'image' => 'programs/bilingual.jpg', 'icon' => 'bi bi-translate', 'duration' => '2 semester', 'age_group' => 'Kelas 7 – 9',
                'excerpt' => 'Pembiasaan bahasa Arab dan Inggris melalui percakapan harian, pidato, dan kegiatan kelas.',
                'content' => '<p>Kelas bilingual membiasakan siswa menggunakan bahasa Arab dan Inggris dalam kegiatan sehari-hari.</p><ul><li>Kosakata harian (mufradat &amp; vocabulary)</li><li>Latihan pidato tiga bahasa</li><li>English &amp; Arabic Day setiap pekan</li></ul>'],
            ['title' => 'Literasi Digital', 'image' => 'programs/digital.jpg', 'icon' => 'bi bi-laptop', 'duration' => '1 semester', 'age_group' => 'Kelas 7 – 9',
                'excerpt' => 'Belajar komputer, desain, dan dasar pemrograman dengan etika bermedia digital.',
                'content' => '<p>Siswa belajar mengoperasikan komputer, membuat presentasi, desain grafis sederhana, hingga dasar pemrograman.</p><ul><li>Etika dan keamanan bermedia sosial</li><li>Proyek desain poster dakwah</li><li>Pengenalan coding</li></ul>'],
            ['title' => 'Penguatan Karakter', 'image' => 'programs/karakter.jpg', 'icon' => 'bi bi-compass', 'duration' => 'Berkelanjutan', 'age_group' => 'Semua kelas',
                'excerpt' => 'Pembiasaan adab, kepemimpinan, dan kepedulian melalui kegiatan harian dan organisasi siswa.',
                'content' => '<p>Penguatan karakter diintegrasikan dalam kegiatan harian: salat berjamaah, piket kelas, organisasi siswa, dan kegiatan sosial.</p><ul><li>Latihan dasar kepemimpinan</li><li>Program kakak asuh</li><li>Kegiatan sosial rutin</li></ul>'],
        ];
    }

    public static function galleries(): array
    {
        return [
            ['title' => 'Upacara Hari Senin', 'prefix' => 'upacara', 'location' => 'Halaman sekolah', 'description' => 'Upacara bendera rutin untuk menumbuhkan disiplin dan cinta tanah air.'],
            ['title' => 'Class Meeting Olahraga', 'prefix' => 'olahraga', 'location' => 'Lapangan sekolah', 'description' => 'Pertandingan sepak bola dan olahraga lain antar kelas setelah penilaian akhir semester.'],
            ['title' => 'Perkemahan Pramuka', 'prefix' => 'pramuka', 'location' => 'Bumi perkemahan', 'description' => 'Perkemahan Sabtu–Minggu untuk melatih kemandirian, kerja sama, dan kepemimpinan.'],
            ['title' => 'Suasana Belajar di Kelas', 'prefix' => 'kelas', 'location' => 'Ruang kelas', 'description' => 'Dokumentasi kegiatan belajar mengajar sehari-hari.'],
        ];
    }

    public static function announcements(): array
    {
        return [
            ['title' => 'Jadwal Penilaian Akhir Semester', 'priority' => 'high', 'content' => '<p>Penilaian Akhir Semester dilaksanakan selama satu pekan. Siswa diharapkan hadir 15 menit sebelum ujian dimulai dan membawa kartu ujian.</p>'],
            ['title' => 'Libur Semester dan Pembagian Rapor', 'priority' => 'normal', 'content' => '<p>Pembagian rapor dilakukan oleh wali kelas kepada orang tua/wali siswa. Libur semester berlangsung dua pekan setelah pembagian rapor.</p>'],
            ['title' => 'Rapat Orang Tua Siswa Baru', 'priority' => 'urgent', 'content' => '<p>Diberitahukan kepada seluruh orang tua siswa baru untuk menghadiri rapat sosialisasi program sekolah di aula. Kehadiran sangat diharapkan.</p>'],
        ];
    }

    public static function downloads(): array
    {
        return [
            ['title' => 'Brosur PPDB', 'file' => 'downloads/brosur-ppdb.pdf', 'description' => 'Informasi program, jadwal, dan syarat pendaftaran peserta didik baru.'],
            ['title' => 'Kalender Akademik', 'file' => 'downloads/kalender-akademik.pdf', 'description' => 'Agenda kegiatan sekolah selama satu tahun pelajaran.'],
            ['title' => 'Formulir Pendaftaran Siswa Baru', 'file' => 'downloads/formulir-pendaftaran.pdf', 'description' => 'Formulir yang dicetak dan diisi saat pendaftaran.'],
        ];
    }

    public static function testimonials(): array
    {
        return [
            ['name' => 'Ibu Siti Aminah', 'position' => 'Wali Siswa', 'company' => 'Kelas 8', 'photo' => 'testimonials/wali-siswa.jpg', 'testimonial' => 'Anak saya jadi lebih rajin salat dan mengaji. Guru-gurunya komunikatif dan selalu memberi kabar perkembangan anak.'],
            ['name' => 'Muhammad Rizki', 'position' => 'Alumni', 'company' => 'Angkatan 2022', 'photo' => 'testimonials/alumni.jpg', 'testimonial' => 'Bekal hafalan dan kebiasaan disiplin dari sekolah sangat membantu saya saat melanjutkan ke jenjang berikutnya.'],
            ['name' => 'Ustadzah Fatimah', 'position' => 'Guru Tahfidz', 'company' => 'Sekolah', 'photo' => 'testimonials/guru.jpg', 'testimonial' => 'Bahagia melihat semangat siswa menyetorkan hafalan setiap pagi. Lingkungan sekolah sangat mendukung.'],
        ];
    }

    public static function faqs(): array
    {
        return [
            ['question' => 'Kapan pendaftaran siswa baru dibuka?', 'answer' => 'Pendaftaran dibuka dalam dua gelombang, biasanya mulai bulan Januari. Jadwal lengkap tersedia di menu Pengumuman dan brosur PPDB.'],
            ['question' => 'Apa saja syarat pendaftaran?', 'answer' => 'Fotokopi akta kelahiran, kartu keluarga, pas foto 3×4, rapor terakhir, dan formulir pendaftaran yang sudah diisi.'],
            ['question' => 'Apakah tersedia program tahfidz?', 'answer' => 'Ya. Program tahfidz dilaksanakan setiap hari dengan target hafalan bertahap dan pendampingan guru.'],
            ['question' => 'Bagaimana cara menghubungi sekolah?', 'answer' => 'Melalui menu Kontak, WhatsApp admin, atau datang langsung ke kantor sekolah pada jam kerja.'],
        ];
    }

    public static function runningTexts(): array
    {
        return [
            ['text' => 'Pendaftaran peserta didik baru telah dibuka — unduh brosur dan formulir di menu Download.', 'link' => '/download'],
            ['text' => 'Selamat kepada siswa yang meraih juara olimpiade sains tingkat kabupaten!', 'link' => '/berita'],
            ['text' => 'Ikuti kegiatan sekolah terbaru melalui menu Galeri.', 'link' => '/galeri'],
        ];
    }

    public static function features(): array
    {
        return [
            ['title' => 'Guru Berpengalaman', 'description' => 'Pendidik yang kompeten dan peduli pada perkembangan setiap siswa.', 'icon' => 'bi bi-person-check'],
            ['title' => 'Lingkungan Islami', 'description' => 'Pembiasaan ibadah dan adab dalam kegiatan sehari-hari.', 'icon' => 'bi bi-moon-stars'],
            ['title' => 'Fasilitas Lengkap', 'description' => 'Perpustakaan, laboratorium komputer, musala, dan lapangan olahraga.', 'icon' => 'bi bi-building'],
            ['title' => 'Prestasi Gemilang', 'description' => 'Pembinaan akademik dan non-akademik untuk meraih prestasi.', 'icon' => 'bi bi-trophy'],
        ];
    }

    public static function statistics(): array
    {
        return [
            ['title' => 'Siswa Aktif', 'value' => '480', 'icon' => 'bi bi-people', 'description' => 'Contoh: jumlah siswa saat ini'],
            ['title' => 'Guru & Tenaga Kependidikan', 'value' => '42', 'icon' => 'bi bi-person-badge', 'description' => 'Contoh: jumlah pendidik'],
            ['title' => 'Prestasi', 'value' => '75+', 'icon' => 'bi bi-award', 'description' => 'Contoh: prestasi lima tahun terakhir'],
            ['title' => 'Ekstrakurikuler', 'value' => '12', 'icon' => 'bi bi-stars', 'description' => 'Contoh: pilihan kegiatan'],
        ];
    }

    public static function quickLinks(): array
    {
        return [
            ['title' => 'Kalender Akademik', 'url' => '/download', 'icon' => 'bi bi-calendar3', 'image' => 'quick-links/kalender.jpg'],
            ['title' => 'Formulir PPDB', 'url' => '/download', 'icon' => 'bi bi-pencil-square', 'image' => 'quick-links/formulir.jpg'],
        ];
    }

    public static function institutionContacts(): array
    {
        return [
            ['name' => 'Admin PPDB', 'contact_person' => 'Panitia PPDB', 'phone' => '081234567890', 'description' => 'Informasi pendaftaran siswa baru'],
            ['name' => 'Tata Usaha', 'contact_person' => 'Staf TU', 'phone' => '081234567891', 'description' => 'Administrasi dan surat-menyurat'],
        ];
    }

    public const PAGE_SLUG = 'contoh-profil-sekolah';

    /* ------------------------------------------------------------------ */
    /*  Seeding                                                            */
    /* ------------------------------------------------------------------ */

    private function copyAssets(): void
    {
        $source = database_path('seeders/demo-assets');
        $disk = Storage::disk('public');

        foreach (File::allFiles($source) as $file) {
            $target = self::STORAGE_DIR . '/' . str_replace('\\', '/', $file->getRelativePathname());
            $disk->put($target, File::get($file->getPathname()));
        }
    }

    private function path(string $relative): string
    {
        return self::STORAGE_DIR . '/' . $relative;
    }

    private function seedCategories(): array
    {
        $defaults = [
            'berita' => ['name' => 'Berita', 'color' => '#12664f'],
            'kegiatan' => ['name' => 'Kegiatan', 'color' => '#dda937'],
            'prestasi' => ['name' => 'Prestasi', 'color' => '#1d4ed8'],
            'galeri' => ['name' => 'Galeri', 'color' => '#0f766e'],
            'dokumen' => ['name' => 'Dokumen', 'color' => '#64748b'],
        ];

        $ids = [];
        foreach ($defaults as $slug => $data) {
            $category = Category::firstOrCreate(['slug' => $slug], $data + ['is_active' => true]);
            $ids[$slug] = $category->id;
        }

        return $ids;
    }

    private function seedSliders(): void
    {
        foreach (self::sliders() as $i => $s) {
            Slider::updateOrCreate(['title' => $s['title']], [
                'description' => $s['description'],
                'image' => $this->path($s['image']),
                'button_text' => $s['button_text'],
                'button_link' => $s['button_link'],
                'order' => $i + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedRunningTexts(): void
    {
        foreach (self::runningTexts() as $i => $t) {
            RunningText::updateOrCreate(['text' => $t['text']], ['link' => $t['link'], 'order' => $i + 1, 'is_active' => true]);
        }
    }

    private function seedPosts(array $categories): void
    {
        $userId = User::query()->orderBy('id')->value('id');
        if (!$userId) {
            $this->command?->warn('Belum ada user admin, berita dilewati. Jalankan UserSeeder terlebih dahulu.');

            return;
        }

        foreach (self::posts() as $i => $p) {
            Post::updateOrCreate(['slug' => Str::slug($p['title'])], [
                'title' => $p['title'],
                'excerpt' => $p['excerpt'],
                'content' => $p['content'] . self::NOTE,
                'featured_image' => $this->path($p['image']),
                'category_id' => $categories[$p['category']],
                'user_id' => $userId,
                'meta_title' => $p['title'],
                'meta_description' => $p['excerpt'],
                'is_published' => true,
                'is_featured' => $p['featured'],
                'views' => 40 + ($i * 37) % 300,
                'published_at' => now()->subDays($i * 3),
            ]);
        }
    }

    private function seedPrograms(): void
    {
        foreach (self::programs() as $i => $p) {
            Program::updateOrCreate(['slug' => Str::slug($p['title'])], [
                'title' => $p['title'],
                'excerpt' => $p['excerpt'],
                'content' => $p['content'] . self::NOTE,
                'featured_image' => $this->path($p['image']),
                'icon' => $p['icon'],
                'duration' => $p['duration'],
                'age_group' => $p['age_group'],
                'price' => null,
                'is_featured' => $i < 2,
                'is_active' => true,
                'order' => $i + 1,
            ]);
        }
    }

    private function seedGalleries(array $categories): void
    {
        foreach (self::galleries() as $i => $g) {
            $images = array_map(fn ($n) => $this->path("galleries/{$g['prefix']}-{$n}.jpg"), [1, 2, 3]);

            $gallery = Gallery::updateOrCreate(['slug' => Str::slug($g['title'])], [
                'title' => $g['title'],
                'description' => $g['description'],
                'content' => '<p>' . e($g['description']) . '</p>' . self::NOTE,
                'image' => $images[0],
                'featured_image' => $images[0],
                'thumbnail' => $images[0],
                'type' => 'image',
                'category_id' => $categories['galeri'],
                'event_date' => now()->subDays(5 + $i * 7),
                'location' => $g['location'],
                'is_featured' => $i < 2,
                'order' => $i + 1,
                'is_active' => true,
            ]);

            // Kolom images tidak ada di $fillable model.
            $gallery->forceFill(['images' => $images])->save();
        }
    }

    private function seedAnnouncements(): void
    {
        foreach (self::announcements() as $i => $a) {
            Announcement::updateOrCreate(['slug' => Str::slug($a['title'])], [
                'title' => $a['title'],
                'content' => $a['content'] . self::NOTE,
                'priority' => $a['priority'],
                'is_active' => true,
                'start_date' => now()->subDay(),
                'end_date' => now()->addDays(60 + $i * 15),
            ]);
        }
    }

    private function seedDownloads(array $categories): void
    {
        $disk = Storage::disk('public');

        foreach (self::downloads() as $d) {
            $path = $this->path($d['file']);
            Download::updateOrCreate(['title' => $d['title']], [
                'description' => $d['description'],
                'file_path' => $path,
                'file_name' => basename($path),
                'file_type' => 'pdf',
                'file_size' => $disk->exists($path) ? $disk->size($path) : 0,
                'category_id' => $categories['dokumen'],
                'is_active' => true,
            ]);
        }
    }

    private function seedTestimonials(): void
    {
        foreach (self::testimonials() as $i => $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], [
                'position' => $t['position'],
                'company' => $t['company'],
                'testimonial' => $t['testimonial'],
                'photo' => $this->path($t['photo']),
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'order' => $i + 1,
            ]);
        }
    }

    private function seedFaqs(): void
    {
        foreach (self::faqs() as $i => $f) {
            Faq::updateOrCreate(['question' => $f['question']], [
                'answer' => '<p>' . e($f['answer']) . '</p>',
                'order' => $i + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedHomeSections(): void
    {
        foreach (self::features() as $i => $f) {
            Feature::updateOrCreate(['title' => $f['title']], $f + ['order' => $i + 1, 'is_active' => true]);
        }

        foreach (self::statistics() as $i => $s) {
            Statistic::updateOrCreate(['title' => $s['title']], $s + ['order' => $i + 1, 'is_active' => true]);
        }

        foreach (self::quickLinks() as $i => $l) {
            QuickLink::updateOrCreate(['title' => $l['title']], [
                'url' => $l['url'],
                'icon' => $l['icon'],
                'image' => $this->path($l['image']),
                'order' => $i + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedInstitutionContacts(): void
    {
        foreach (self::institutionContacts() as $i => $c) {
            InstitutionContact::updateOrCreate(['name' => $c['name']], $c + [
                'icon' => 'bi bi-whatsapp',
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedPage(): void
    {
        Page::updateOrCreate(['slug' => self::PAGE_SLUG], [
            'title' => 'Contoh Halaman Profil Sekolah',
            'content' => '<p>Halaman ini mencontohkan cara menyusun halaman statis: teks, subjudul, daftar, tabel, dan gambar.</p>'
                . '<img src="/storage/demo/sliders/gedung-sekolah.jpg" alt="Gedung sekolah">'
                . '<h2>Sejarah Singkat</h2><p>Tuliskan sejarah berdirinya sekolah, tokoh pendiri, dan perkembangan dari tahun ke tahun.</p>'
                . '<h2>Visi</h2><p>Tuliskan visi sekolah dalam satu atau dua kalimat.</p>'
                . '<h2>Misi</h2><ol><li>Misi pertama</li><li>Misi kedua</li><li>Misi ketiga</li></ol>'
                . '<h2>Data Singkat</h2><table><tbody><tr><th>NPSN</th><td>00000000</td></tr><tr><th>Akreditasi</th><td>A</td></tr><tr><th>Tahun berdiri</th><td>1990</td></tr></tbody></table>'
                . self::NOTE,
            'meta_title' => 'Contoh Halaman Profil Sekolah',
            'meta_description' => 'Contoh halaman statis untuk profil sekolah.',
            'is_active' => true,
        ]);
    }

    /**
     * Data lama (mis. dari SampleDataSeeder) menunjuk ke gambar yang tidak pernah ada,
     * sehingga tampil rusak. Ganti hanya yang file-nya benar-benar hilang.
     */
    private function repairMissingImages(): void
    {
        $disk = Storage::disk('public');
        $fallbacks = [
            [Slider::class, 'image', array_column(self::sliders(), 'image')],
            [Post::class, 'featured_image', array_column(self::posts(), 'image')],
            [Program::class, 'featured_image', array_column(self::programs(), 'image')],
            [Testimonial::class, 'photo', array_column(self::testimonials(), 'photo')],
        ];

        $fixed = 0;
        foreach ($fallbacks as [$model, $column, $images]) {
            $i = 0;
            $model::query()->whereNotNull($column)->where($column, '!=', '')->each(function ($row) use ($disk, $column, $images, &$i, &$fixed) {
                if ($disk->exists($row->{$column})) {
                    return;
                }
                $row->forceFill([$column => $this->path($images[$i++ % count($images)])])->save();
                $fixed++;
            });
        }

        if ($fixed) {
            $this->command?->info("{$fixed} data lama dengan gambar hilang sudah diberi gambar contoh.");
        }
    }
}
