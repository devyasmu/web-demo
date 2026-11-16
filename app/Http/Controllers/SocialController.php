<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Support\SpamGuard;

class SocialController extends Controller
{
    private const LIKEABLE_TYPES = [
        'post' => \App\Models\Post::class,
        'announcement' => \App\Models\Announcement::class,
        'program' => \App\Models\Program::class,
        'gallery' => \App\Models\Gallery::class,
    ];

    /**
     * Toggle like for a post/announcement
     */
    public function toggleLike(Request $request): JsonResponse
    {
        $request->validate([
            'item_type' => 'required|string|in:post,announcement,program,gallery',
            'item_id' => 'required|integer|min:1',
        ]);

        $modelClass = self::LIKEABLE_TYPES[$request->item_type];
        if (!$modelClass::whereKey($request->item_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan.'], 404);
        }

        $userIp = $request->ip();
        $userAgent = mb_substr((string) $request->userAgent(), 0, 255);

        $isLiked = Like::toggleLike(
            $request->item_type,
            $request->item_id,
            $userIp,
            $userAgent
        );

        // Get updated likes count
        $likesCount = Like::where('likeable_type', $request->item_type)
                         ->where('likeable_id', $request->item_id)
                         ->count();

        return response()->json([
            'success' => true,
            'liked' => $isLiked,
            'likes_count' => $likesCount,
            'message' => $isLiked ? 'Item berhasil di-like!' : 'Item berhasil di-unlike!'
        ]);
    }

    /**
     * Tipe item yang boleh dikomentari (dikirim dari form sebagai nama class).
     */
    private const COMMENTABLE_TYPES = [
        'App\\Models\\Post' => \App\Models\Post::class,
        'App\\Models\\Announcement' => \App\Models\Announcement::class,
        'App\\Models\\Program' => \App\Models\Program::class,
        'App\\Models\\Gallery' => \App\Models\Gallery::class,
    ];

    /**
     * Store a new comment
     */
    public function storeComment(Request $request): JsonResponse
    {
        $request->validate([
            'item_type' => ['required', 'string', Rule::in(array_keys(self::COMMENTABLE_TYPES))],
            'item_id' => 'required|integer|min:1',
            'name' => ['required', 'string', 'min:2', 'max:100', 'not_regex:~(https?://|www\.|<|>)~i'],
            'email' => 'required|email|max:255',
            'content' => 'required|string|min:3|max:1000',
        ]);

        $spamReason = SpamGuard::check($request, ['name', 'content']);
        if ($spamReason === 'honeypot') {
            // Bot: pura-pura berhasil supaya tidak mencoba cara lain, tapi tidak disimpan.
            Log::notice('Comment blocked', ['reason' => $spamReason, 'ip' => $request->ip()]);
            return response()->json(['success' => true, 'message' => 'Komentar berhasil dikirim!']);
        }
        if ($spamReason !== null) {
            Log::notice('Comment blocked', ['reason' => $spamReason, 'ip' => $request->ip()]);
            return response()->json([
                'success' => false,
                'message' => in_array($spamReason, ['too_many_links', 'blocked_word'], true)
                    ? 'Komentar ditolak karena terdeteksi sebagai spam.'
                    : 'Sesi formulir tidak valid. Muat ulang halaman lalu coba lagi.',
            ], 422);
        }

        $modelClass = self::COMMENTABLE_TYPES[$request->item_type];
        if (!$modelClass::whereKey($request->item_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan.'], 404);
        }

        $content = trim(strip_tags($request->content));
        $isDuplicate = Comment::where('user_ip', $request->ip())
            ->where('content', $content)
            ->where('created_at', '>=', now()->subDay())
            ->exists();
        if ($isDuplicate) {
            return response()->json(['success' => false, 'message' => 'Komentar yang sama sudah pernah dikirim.'], 422);
        }

        Comment::create([
            'commentable_type' => $request->item_type,
            'commentable_id' => $request->item_id,
            'name' => trim(strip_tags($request->name)),
            'email' => $request->email,
            'content' => $content,
            'user_ip' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 255),
            'is_approved' => false, // Require admin approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dikirim!'
        ]);
    }

    /**
     * Get comments for a specific item
     */
    public function getComments(Request $request): JsonResponse
    {
        $request->validate([
            'item_type' => 'required|string|in:post,announcement,program,gallery',
            'item_id' => 'required|integer',
        ]);

        $comments = Comment::where('commentable_type', $request->item_type)
                          ->where('commentable_id', $request->item_id)
                          ->where('is_approved', true)
                          ->recent()
                          ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'name' => $comment->name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->toISOString(),
                ];
            })
        ]);
    }

    /**
     * Check if user has liked an item
     */
    public function checkLike(Request $request): JsonResponse
    {
        $request->validate([
            'item_type' => 'required|string|in:post,announcement,program,gallery',
            'item_id' => 'required|integer',
        ]);

        $userIp = $request->ip();
        $hasLiked = Like::hasLiked($request->item_type, $request->item_id, $userIp);

        return response()->json([
            'success' => true,
            'has_liked' => $hasLiked
        ]);
    }
}