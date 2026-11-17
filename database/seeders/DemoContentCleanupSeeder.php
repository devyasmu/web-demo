<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Comment;
use App\Models\Download;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\InstitutionContact;
use App\Models\Like;
use App\Models\Page;
use App\Models\Post;
use App\Models\Program;
use App\Models\QuickLink;
use App\Models\RunningText;
use App\Models\Slider;
use App\Models\Statistic;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Menghapus semua data dummy dari DemoContentSeeder, beserta gambar dan PDF-nya.
 *
 *   php artisan db:seed --class=DemoContentCleanupSeeder --force
 *
 * Yang dihapus: data yang gambarnya/berkasnya ada di folder storage "demo/",
 * dan data teks yang judulnya persis sama dengan data dummy.
 * Data yang sudah diedit admin (gambar diganti dan judul diubah) tidak ikut terhapus.
 * Kategori dan menu tidak dihapus.
 */
class DemoContentCleanupSeeder extends Seeder
{
    public function run(): void
    {
        $prefix = DemoContentSeeder::STORAGE_DIR . '/%';
        $deleted = 0;

        // Data bergambar: dikenali dari lokasi gambarnya.
        $byImage = [
            [Slider::class, 'image'],
            [Testimonial::class, 'photo'],
            [QuickLink::class, 'image'],
            [Download::class, 'file_path'],
        ];
        foreach ($byImage as [$model, $column]) {
            $deleted += $model::query()->where($column, 'like', $prefix)->delete();
        }

        // Konten yang bisa di-like/dikomentari: hapus juga komentar dan like-nya
        // (relasi polimorfik tanpa cascade).
        $social = [
            [Post::class, 'featured_image'],
            [Program::class, 'featured_image'],
            [Gallery::class, 'image'],
        ];
        foreach ($social as [$model, $column]) {
            $ids = $model::query()->where($column, 'like', $prefix)->pluck('id')->all();
            $deleted += $this->deleteWithSocial($model, $ids);
        }

        $announcementIds = Announcement::query()
            ->whereIn('slug', array_map(fn ($a) => Str::slug($a['title']), DemoContentSeeder::announcements()))
            ->pluck('id');
        $deleted += $this->deleteWithSocial(Announcement::class, $announcementIds->all());

        // Data teks: dikenali dari judul persis.
        $deleted += Faq::query()->whereIn('question', array_column(DemoContentSeeder::faqs(), 'question'))->delete();
        $deleted += RunningText::query()->whereIn('text', array_column(DemoContentSeeder::runningTexts(), 'text'))->delete();
        $deleted += Feature::query()->whereIn('title', array_column(DemoContentSeeder::features(), 'title'))->delete();
        $deleted += Statistic::query()->whereIn('title', array_column(DemoContentSeeder::statistics(), 'title'))->delete();
        $deleted += InstitutionContact::query()->whereIn('name', array_column(DemoContentSeeder::institutionContacts(), 'name'))->delete();
        $deleted += Page::query()->where('slug', DemoContentSeeder::PAGE_SLUG)->delete();

        Storage::disk('public')->deleteDirectory(DemoContentSeeder::STORAGE_DIR);

        $this->command?->info("{$deleted} data dummy dihapus, folder storage/app/public/" . DemoContentSeeder::STORAGE_DIR . ' dibersihkan.');
    }

    private function deleteWithSocial(string $model, array $ids): int
    {
        if (!$ids) {
            return 0;
        }

        // Like menyimpan tipe pendek ("post"), komentar menyimpan nama class lengkap.
        $types = [$model, Str::lower(class_basename($model))];

        Comment::query()->whereIn('commentable_type', $types)->whereIn('commentable_id', $ids)->delete();
        Like::query()->whereIn('likeable_type', $types)->whereIn('likeable_id', $ids)->delete();

        return $model::query()->whereIn('id', $ids)->delete();
    }
}
