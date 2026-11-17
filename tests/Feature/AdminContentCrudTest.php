<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Download;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Jalankan dengan SQLite in-memory:
 *   DB_CONNECTION=sqlite DB_DATABASE=:memory: php artisan test --filter=AdminContentCrudTest
 */
class AdminContentCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_announcement_can_be_created_updated_and_deleted(): void
    {
        $this->get(route('admin.announcements.create'))->assertOk();

        $this->post(route('admin.announcements.store'), [
            'title' => 'Libur Semester',
            'content' => '<p>Libur dua pekan.</p>',
            'priority' => 'high',
            'start_date' => '2026-12-01',
            'end_date' => '2026-12-14',
            'is_active' => '1',
        ])->assertRedirect(route('admin.announcements.index'));

        $announcement = Announcement::firstOrFail();
        $this->assertSame('libur-semester', $announcement->slug);
        $this->assertTrue($announcement->is_active);

        // Judul sama menghasilkan slug unik.
        $this->post(route('admin.announcements.store'), [
            'title' => 'Libur Semester', 'content' => 'x', 'priority' => 'normal',
        ]);
        $this->assertSame('libur-semester-2', Announcement::latest('id')->first()->slug);

        $this->get(route('admin.announcements.edit', $announcement))->assertOk()->assertSee('Libur Semester');

        $this->put(route('admin.announcements.update', $announcement), [
            'title' => 'Libur Akhir Semester',
            'content' => '<p>Diubah.</p>',
            'priority' => 'urgent',
        ])->assertRedirect(route('admin.announcements.index'));

        $announcement->refresh();
        $this->assertSame('libur-akhir-semester', $announcement->slug);
        $this->assertSame('urgent', $announcement->priority);
        $this->assertFalse($announcement->is_active);

        $this->delete(route('admin.announcements.destroy', $announcement))->assertRedirect();
        $this->assertModelMissing($announcement);
    }

    public function test_announcement_end_date_cannot_precede_start_date(): void
    {
        $this->post(route('admin.announcements.store'), [
            'title' => 'Salah', 'content' => 'x', 'priority' => 'normal',
            'start_date' => '2026-12-10', 'end_date' => '2026-12-01',
        ])->assertSessionHasErrors('end_date');
    }

    public function test_faq_can_be_created_updated_and_deleted(): void
    {
        $this->get(route('admin.faqs.create'))->assertOk();

        $this->post(route('admin.faqs.store'), [
            'question' => 'Kapan PPDB dibuka?',
            'answer' => '<p>Januari.</p>',
            'order' => 2,
            'is_active' => '1',
        ])->assertRedirect(route('admin.faqs.index'));

        $faq = Faq::firstOrFail();
        $this->get(route('admin.faqs.edit', $faq))->assertOk();

        $this->put(route('admin.faqs.update', $faq), [
            'question' => 'Kapan PPDB dibuka?',
            'answer' => '<p>Februari.</p>',
        ])->assertRedirect(route('admin.faqs.index'));

        $faq->refresh();
        $this->assertSame('<p>Februari.</p>', $faq->answer);
        $this->assertSame(0, $faq->order);
        $this->assertFalse($faq->is_active);

        $this->delete(route('admin.faqs.destroy', $faq))->assertRedirect();
        $this->assertModelMissing($faq);
    }

    public function test_download_upload_replace_and_delete_manage_the_file(): void
    {
        Storage::fake('public');
        $this->get(route('admin.downloads.create'))->assertOk();

        $this->post(route('admin.downloads.store'), [
            'title' => 'Kalender Akademik',
            'file' => UploadedFile::fake()->create('Kalender Akademik 2026.pdf', 120, 'application/pdf'),
            'is_active' => '1',
        ])->assertRedirect(route('admin.downloads.index'));

        $download = Download::firstOrFail();
        $this->assertSame('kalender-akademik-2026.pdf', $download->file_name);
        $this->assertSame('pdf', $download->file_type);
        Storage::disk('public')->assertExists($download->file_path);
        $firstPath = $download->file_path;

        // Edit tanpa file baru: file lama tetap.
        $this->put(route('admin.downloads.update', $download), ['title' => 'Kalender Baru', 'is_active' => '1'])
            ->assertRedirect(route('admin.downloads.index'));
        $this->assertSame($firstPath, $download->fresh()->file_path);

        // Ganti file: file lama dihapus.
        $this->put(route('admin.downloads.update', $download), [
            'title' => 'Kalender Baru',
            'file' => UploadedFile::fake()->create('kalender.docx', 50),
        ]);
        $download->refresh();
        Storage::disk('public')->assertMissing($firstPath);
        Storage::disk('public')->assertExists($download->file_path);
        $this->assertSame('docx', $download->file_type);

        $this->delete(route('admin.downloads.destroy', $download))->assertRedirect();
        Storage::disk('public')->assertMissing($download->file_path);
        $this->assertModelMissing($download);
    }

    public function test_running_text_link_accepts_internal_and_full_urls_only(): void
    {
        foreach (['/berita', 'https://contoh.sch.id/ppdb', ''] as $link) {
            $this->post(route('admin.running-texts.store'), ['text' => 'Info', 'link' => $link])
                ->assertSessionHasNoErrors();
        }

        foreach (['javascript:alert(1)', '//evil.test', 'berita'] as $link) {
            $this->post(route('admin.running-texts.store'), ['text' => 'Info', 'link' => $link])
                ->assertSessionHasErrors('link');
        }
    }

    public function test_admin_guide_is_reachable_and_every_toc_link_has_a_section(): void
    {
        $html = $this->get(route('admin.guide'))->assertOk()->assertSee('Panduan')->getContent();

        preg_match_all('/data-toc-for="([a-z-]+)"/', $html, $links);
        $this->assertNotEmpty($links[1]);
        foreach ($links[1] as $id) {
            $this->assertStringContainsString('<section id="' . $id . '"', $html, "Bagian #{$id} tidak ada.");
        }

        $this->get(route('admin.dashboard'))->assertOk()->assertSee(route('admin.guide'));
    }

    public function test_guide_requires_login(): void
    {
        auth()->logout();
        $this->get(route('admin.guide'))->assertNotFound();
    }

    public function test_page_forms_render(): void
    {
        $this->get(route('admin.pages.create'))->assertOk()->assertDontSee('name="featured_image"', false);
        $page = \App\Models\Page::create(['title' => 'Profil', 'slug' => 'profil', 'content' => '<p>x</p>', 'is_active' => true]);
        $this->get(route('admin.pages.edit', $page))->assertOk();
    }

    public function test_download_rejects_disallowed_file_types(): void
    {
        Storage::fake('public');

        $this->post(route('admin.downloads.store'), [
            'title' => 'Berbahaya',
            'file' => UploadedFile::fake()->create('script.php', 1, 'application/x-php'),
        ])->assertSessionHasErrors('file');

        $this->assertSame(0, Download::count());
    }
}
