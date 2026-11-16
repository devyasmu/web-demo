<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Contact;
use App\Support\SpamGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Jalankan dengan SQLite in-memory:
 *   DB_CONNECTION=sqlite DB_DATABASE=:memory: php artisan test --filter=SpamProtectionTest
 */
class SpamProtectionTest extends TestCase
{
    use RefreshDatabase;

    private int $postId;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::disableForeignKeyConstraints();
        $this->postId = DB::table('posts')->insertGetId([
            'title' => 'Berita', 'slug' => 'berita', 'content' => 'Isi',
            'category_id' => 1, 'user_id' => 1, 'is_published' => true,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        Schema::enableForeignKeyConstraints();
    }

    private function validToken(int $secondsAgo = 10): string
    {
        return Crypt::encryptString((string) (time() - $secondsAgo));
    }

    private function commentPayload(array $overrides = []): array
    {
        return array_merge([
            'item_type' => 'App\\Models\\Post',
            'item_id' => $this->postId,
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'content' => 'Artikel yang sangat bermanfaat.',
            SpamGuard::TIMESTAMP_FIELD => $this->validToken(),
        ], $overrides);
    }

    public function test_valid_comment_is_saved_pending_approval(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload())
            ->assertOk()->assertJson(['success' => true]);

        $comment = Comment::sole();
        $this->assertFalse($comment->is_approved);
    }

    public function test_honeypot_comment_is_silently_dropped(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload([SpamGuard::HONEYPOT_FIELD => 'http://spam.example']))
            ->assertOk()->assertJson(['success' => true]);

        $this->assertSame(0, Comment::count());
    }

    public function test_comment_without_or_with_forged_token_is_rejected(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload([SpamGuard::TIMESTAMP_FIELD => null]))
            ->assertStatus(422);
        $this->postJson('/api/social/comment', $this->commentPayload([SpamGuard::TIMESTAMP_FIELD => (string) (time() - 60)]))
            ->assertStatus(422);

        $this->assertSame(0, Comment::count());
    }

    public function test_comment_submitted_too_fast_is_rejected(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload([SpamGuard::TIMESTAMP_FIELD => $this->validToken(0)]))
            ->assertStatus(422);

        $this->assertSame(0, Comment::count());
    }

    public function test_link_spam_and_blocked_words_are_rejected(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload([
            'content' => 'Kunjungi https://a.example dan https://b.example sekarang',
        ]))->assertStatus(422);

        $this->postJson('/api/social/comment', $this->commentPayload([
            'content' => 'Daftar SLOT GACOR hari ini',
        ]))->assertStatus(422);

        $this->postJson('/api/social/comment', $this->commentPayload([
            'name' => 'www.spam.example',
        ]))->assertStatus(422);

        $this->assertSame(0, Comment::count());
    }

    public function test_comment_on_missing_item_or_unknown_type_is_rejected(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload(['item_id' => 99999]))
            ->assertStatus(404);
        $this->postJson('/api/social/comment', $this->commentPayload(['item_type' => 'App\\Models\\User']))
            ->assertStatus(422);

        $this->assertSame(0, Comment::count());
    }

    public function test_duplicate_comment_is_rejected(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload())->assertOk();
        $this->postJson('/api/social/comment', $this->commentPayload())->assertStatus(422);

        $this->assertSame(1, Comment::count());
    }

    public function test_html_is_stripped_from_comments(): void
    {
        $this->postJson('/api/social/comment', $this->commentPayload([
            'content' => '<script>alert(1)</script>Halo admin',
        ]))->assertOk();

        $this->assertSame('alert(1)Halo admin', Comment::sole()->content);
    }

    public function test_comment_flood_is_rate_limited(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $this->postJson('/api/social/comment', $this->commentPayload(['content' => "Komentar ke-$i"]))->assertOk();
        }

        $this->postJson('/api/social/comment', $this->commentPayload(['content' => 'Komentar ke-4']))
            ->assertStatus(429);

        $this->assertSame(3, Comment::count());
    }

    public function test_contact_form_ignores_extra_fields_like_is_read(): void
    {
        $this->post('/contacts', [
            'name' => 'Siti',
            'email' => 'siti@example.com',
            'subject' => 'Pendaftaran',
            'message' => 'Bagaimana cara mendaftar?',
            'is_read' => 1,
            SpamGuard::TIMESTAMP_FIELD => $this->validToken(),
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertFalse(Contact::sole()->is_read);
    }

    public function test_contact_form_honeypot_and_rate_limit(): void
    {
        $base = [
            'name' => 'Siti',
            'email' => 'siti@example.com',
            'subject' => 'Pendaftaran',
            'message' => 'Bagaimana cara mendaftar?',
            SpamGuard::TIMESTAMP_FIELD => $this->validToken(),
        ];

        $this->post('/contacts', $base + [SpamGuard::HONEYPOT_FIELD => 'bot'])->assertSessionHas('success');
        $this->assertSame(0, Contact::count());

        $this->post('/contacts', $base)->assertSessionHas('success');
        $this->post('/contacts', $base)->assertStatus(429);
        $this->assertSame(1, Contact::count());
    }

    public function test_like_on_missing_item_is_rejected(): void
    {
        $this->postJson('/api/social/like', ['item_type' => 'post', 'item_id' => 99999])->assertStatus(404);
    }

    public function test_security_headers_are_sent(): void
    {
        $this->get('/api/social/comments?item_type=post&item_id=1')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
    }
}
