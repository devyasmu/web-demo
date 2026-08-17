<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;
use App\Models\RunningText;
use App\Models\Page;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Program;
use App\Models\Announcement;
use App\Models\Download;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::first();

        // Create sample sliders
        Slider::create([
            'title' => 'Selamat Datang di Web Demo Pendidikan',
            'description' => 'Membangun generasi yang berakhlak mulia dan berprestasi',
            'image' => 'sliders/slider1.jpg',
            'button_text' => 'Pelajari Lebih Lanjut',
            'button_link' => '/about',
            'order' => 1,
            'is_active' => true,
        ]);

        Slider::create([
            'title' => 'Program Unggulan Tahfidz Al-Quran',
            'description' => 'Mencetak generasi penghafal Al-Quran yang berkualitas',
            'image' => 'sliders/slider2.jpg',
            'button_text' => 'Daftar Sekarang',
            'button_link' => '/programs',
            'order' => 2,
            'is_active' => true,
        ]);

        // Create sample running texts
        RunningText::create([
            'text' => 'Pendaftaran Siswa Baru Tahun Ajaran 2024/2025 telah dibuka!',
            'link' => '/announcements',
            'order' => 1,
            'is_active' => true,
        ]);

        RunningText::create([
            'text' => 'Program Beasiswa untuk Siswa Berprestasi - Hubungi Admin',
            'link' => '/contact',
            'order' => 2,
            'is_active' => true,
        ]);

        // Create sample pages
        Page::create([
            'title' => 'Tentang Kami',
            'slug' => 'about',
            'content' => '<h2>Sejarah Yayasan</h2><p>Web Demo Pendidikan didirikan pada tahun 1995 dengan visi membangun generasi yang berakhlak mulia dan berprestasi. Kami telah melayani ribuan siswa dan alumni yang tersebar di berbagai penjuru negeri.</p><h2>Visi</h2><p>Menjadi lembaga pendidikan Islam terdepan yang mencetak generasi berakhlak mulia, berprestasi, dan bermanfaat bagi umat.</p><h2>Misi</h2><ul><li>Menyelenggarakan pendidikan Islam yang berkualitas</li><li>Membangun karakter dan akhlak mulia</li><li>Mengembangkan potensi akademik dan non-akademik</li><li>Membentuk generasi yang siap menghadapi tantangan masa depan</li></ul>',
            'meta_title' => 'Tentang Kami - Web Demo Pendidikan',
            'meta_description' => 'Pelajari lebih lanjut tentang sejarah, visi, dan misi Web Demo Pendidikan',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Visi & Misi',
            'slug' => 'vision-mission',
            'content' => '<h2>Visi</h2><p>Menjadi lembaga pendidikan Islam terdepan yang mencetak generasi berakhlak mulia, berprestasi, dan bermanfaat bagi umat.</p><h2>Misi</h2><ul><li>Menyelenggarakan pendidikan Islam yang berkualitas dan terintegrasi</li><li>Membangun karakter dan akhlak mulia berdasarkan Al-Quran dan Sunnah</li><li>Mengembangkan potensi akademik dan non-akademik siswa secara optimal</li><li>Membentuk generasi yang siap menghadapi tantangan masa depan</li><li>Menjalin kerjasama dengan berbagai pihak untuk kemajuan pendidikan</li></ul>',
            'meta_title' => 'Visi & Misi - Web Demo Pendidikan',
            'meta_description' => 'Visi dan misi Web Demo Pendidikan dalam membangun generasi yang berakhlak mulia',
            'is_active' => true,
        ]);

        // Create sample posts
        $beritaCategory = Category::where('name', 'Berita')->first();
        $kegiatanCategory = Category::where('name', 'Kegiatan')->first();

        Post::create([
            'title' => 'Pembukaan Pendaftaran Siswa Baru Tahun Ajaran 2024/2025',
            'slug' => 'pembukaan-pendaftaran-siswa-baru-2024-2025',
            'excerpt' => 'Web Demo Pendidikan membuka pendaftaran siswa baru untuk tahun ajaran 2024/2025. Segera daftarkan putra-putri Anda.',
            'content' => '<p>Web Demo Pendidikan dengan bangga mengumumkan pembukaan pendaftaran siswa baru untuk tahun ajaran 2024/2025. Kami menyediakan program pendidikan yang komprehensif mulai dari tingkat TK, SD, SMP, hingga SMA.</p><h3>Persyaratan Pendaftaran:</h3><ul><li>Mengisi formulir pendaftaran</li><li>Menyerahkan fotokopi akta kelahiran</li><li>Menyerahkan fotokopi KK</li><li>Pas foto 3x4 sebanyak 2 lembar</li><li>Mengikuti tes masuk</li></ul><p>Pendaftaran dibuka mulai tanggal 1 Januari 2024. Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik.</p>',
            'featured_image' => 'posts/pendaftaran-siswa-baru.jpg',
            'category_id' => $beritaCategory->id,
            'user_id' => $admin->id,
            'meta_title' => 'Pendaftaran Siswa Baru 2024/2025 - Web Demo Pendidikan',
            'meta_description' => 'Informasi lengkap tentang pendaftaran siswa baru tahun ajaran 2024/2025 di Web Demo Pendidikan',
            'is_published' => true,
            'is_featured' => true,
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Kegiatan Outbound Siswa Kelas 6 SD',
            'slug' => 'kegiatan-outbound-siswa-kelas-6-sd',
            'excerpt' => 'Siswa kelas 6 SD mengikuti kegiatan outbound di Taman Nasional untuk mengembangkan kerja sama tim.',
            'content' => '<p>Pada hari Sabtu, 15 Oktober 2024, siswa kelas 6 SD Web Demo Pendidikan mengikuti kegiatan outbound di Taman Nasional. Kegiatan ini bertujuan untuk mengembangkan kerja sama tim, kepemimpinan, dan kemandirian siswa.</p><p>Kegiatan outbound meliputi berbagai permainan yang menantang seperti flying fox, jembatan tali, dan permainan team building lainnya. Semua siswa terlihat antusias dan bersemangat mengikuti setiap aktivitas.</p><p>Kegiatan ini diharapkan dapat membangun karakter siswa yang tangguh, mandiri, dan mampu bekerja sama dalam tim.</p>',
            'featured_image' => 'posts/outbound-siswa.jpg',
            'category_id' => $kegiatanCategory->id,
            'user_id' => $admin->id,
            'meta_title' => 'Kegiatan Outbound Siswa Kelas 6 SD - Web Demo Pendidikan',
            'meta_description' => 'Laporan kegiatan outbound siswa kelas 6 SD di Taman Nasional untuk mengembangkan kerja sama tim',
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(2),
        ]);

        // Create sample programs
        Program::create([
            'title' => 'Program Tahfidz Al-Quran',
            'slug' => 'program-tahfidz-al-quran',
            'excerpt' => 'Program khusus untuk menghafal Al-Quran dengan metode yang efektif dan menyenangkan.',
            'content' => '<h3>Deskripsi Program</h3><p>Program Tahfidz Al-Quran adalah program unggulan Web Demo Pendidikan yang dirancang khusus untuk membantu siswa menghafal Al-Quran dengan metode yang efektif dan menyenangkan.</p><h3>Keunggulan Program:</h3><ul><li>Metode pembelajaran yang terstruktur</li><li>Guru yang berpengalaman dan bersertifikat</li><li>Evaluasi berkala untuk memantau perkembangan</li><li>Suasana belajar yang kondusif</li></ul><h3>Target Pencapaian:</h3><p>Siswa diharapkan dapat menghafal minimal 1 juz per tahun dengan kualitas hafalan yang baik.</p>',
            'featured_image' => 'programs/tahfidz-al-quran.jpg',
            'icon' => 'fas fa-quran',
            'duration' => '1 Tahun',
            'age_group' => '7-18 Tahun',
            'price' => 500000,
            'is_featured' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        Program::create([
            'title' => 'Program Bahasa Arab',
            'slug' => 'program-bahasa-arab',
            'excerpt' => 'Belajar bahasa Arab dengan metode komunikatif untuk memahami Al-Quran dan Hadits.',
            'content' => '<h3>Deskripsi Program</h3><p>Program Bahasa Arab dirancang untuk membantu siswa menguasai bahasa Arab dengan metode komunikatif yang menyenangkan.</p><h3>Materi Pembelajaran:</h3><ul><li>Kosakata dasar bahasa Arab</li><li>Struktur kalimat sederhana</li><li>Percakapan sehari-hari</li><li>Pemahaman teks Al-Quran dan Hadits</li></ul>',
            'featured_image' => 'programs/bahasa-arab.jpg',
            'icon' => 'fas fa-language',
            'duration' => '6 Bulan',
            'age_group' => '10-18 Tahun',
            'price' => 300000,
            'is_featured' => false,
            'is_active' => true,
            'order' => 2,
        ]);

        // Create sample announcements
        Announcement::create([
            'title' => 'Libur Semester Ganjil Tahun Ajaran 2024/2025',
            'content' => '<p>Diberitahukan kepada seluruh siswa dan orang tua bahwa libur semester ganjil akan dimulai pada tanggal 20 Desember 2024 dan akan berakhir pada tanggal 6 Januari 2025.</p><p>Selama libur semester, siswa diharapkan untuk:</p><ul><li>Istirahat yang cukup</li><li>Mengisi waktu dengan kegiatan positif</li><li>Mempersiapkan diri untuk semester genap</li></ul><p>Kegiatan belajar mengajar akan dimulai kembali pada tanggal 7 Januari 2025.</p>',
            'priority' => 'high',
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        Announcement::create([
            'title' => 'Jadwal Ujian Akhir Semester Ganjil',
            'content' => '<p>Berikut adalah jadwal ujian akhir semester ganjil tahun ajaran 2024/2025:</p><ul><li>Tanggal 10-15 Desember 2024: Ujian Tulis</li><li>Tanggal 16-18 Desember 2024: Ujian Lisan</li><li>Tanggal 19 Desember 2024: Pengumuman Hasil</li></ul><p>Seluruh siswa diharapkan mempersiapkan diri dengan baik untuk menghadapi ujian ini.</p>',
            'priority' => 'medium',
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(15),
        ]);

        // Create sample FAQs
        Faq::create([
            'question' => 'Bagaimana cara mendaftar sebagai siswa baru?',
            'answer' => '<p>Untuk mendaftar sebagai siswa baru, Anda dapat:</p><ol><li>Mengisi formulir pendaftaran online di website kami</li><li>Atau datang langsung ke kantor yayasan dengan membawa dokumen yang diperlukan</li><li>Mengikuti tes masuk yang akan dijadwalkan</li><li>Melakukan pembayaran biaya pendaftaran</li></ol>',
            'order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Apakah ada program beasiswa untuk siswa berprestasi?',
            'answer' => '<p>Ya, kami menyediakan program beasiswa untuk siswa berprestasi dengan kriteria:</p><ul><li>Memiliki nilai akademik yang baik</li><li>Memiliki prestasi di bidang non-akademik</li><li>Memiliki akhlak yang baik</li><li>Keluarga yang membutuhkan bantuan finansial</li></ul><p>Untuk informasi lebih lanjut, silakan hubungi bagian administrasi.</p>',
            'order' => 2,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Jam operasional yayasan?',
            'answer' => '<p>Jam operasional yayasan adalah:</p><ul><li>Senin - Jumat: 07:00 - 16:00 WIB</li><li>Sabtu: 07:00 - 12:00 WIB</li><li>Minggu: Tutup</li></ul><p>Untuk informasi lebih lanjut, silakan hubungi kami di nomor yang tertera di halaman kontak.</p>',
            'order' => 3,
            'is_active' => true,
        ]);

        // Create sample testimonials
        Testimonial::create([
            'name' => 'Ahmad Rizki',
            'position' => 'Orang Tua Siswa',
            'company' => 'Kelas 5 SD',
            'testimonial' => 'Alhamdulillah, putra saya sangat senang belajar di Web Demo Pendidikan. Metode pembelajaran yang menyenangkan dan guru yang sabar membuat anak saya semakin semangat belajar.',
            'photo' => 'testimonials/ahmad-rizki.jpg',
            'rating' => 5,
            'is_featured' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        Testimonial::create([
            'name' => 'Siti Nurhaliza',
            'position' => 'Alumni',
            'company' => 'Lulusan 2020',
            'testimonial' => 'Berkat pendidikan di Web Demo Pendidikan, saya bisa melanjutkan studi ke perguruan tinggi negeri. Fondasi agama dan akademik yang kuat sangat membantu saya.',
            'photo' => 'testimonials/siti-nurhaliza.jpg',
            'rating' => 5,
            'is_featured' => true,
            'is_active' => true,
            'order' => 2,
        ]);
    }
}