<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SocialController extends Controller
{
    /**
     * Toggle like for a post/announcement
     */
    public function toggleLike(Request $request): JsonResponse
    {
        $request->validate([
            'item_type' => 'required|string|in:post,announcement,program,gallery',
            'item_id' => 'required|integer',
        ]);

        $userIp = $request->ip();
        $userAgent = $request->userAgent();

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
     * Store a new comment
     */
    public function storeComment(Request $request): JsonResponse
    {
        \Log::info('Comment submission attempt', [
            'request_data' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $request->validate([
            'item_type' => 'required|string|in:App\Models\Post,App\Models\Announcement,App\Models\Program,App\Models\Gallery',
            'item_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'commentable_type' => $request->item_type,
            'commentable_id' => $request->item_id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'user_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_approved' => false, // Require admin approval
        ]);

        // Get updated comments count
        $commentsCount = Comment::where('commentable_type', $request->item_type)
                               ->where('commentable_id', $request->item_id)
                               ->where('is_approved', true)
                               ->count();

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'name' => $comment->name,
                'email' => $comment->email,
                'content' => $comment->content,
                'created_at' => $comment->created_at->toISOString(),
            ],
            'comments_count' => $commentsCount,
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