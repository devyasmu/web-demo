<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of comments.
     */
    public function index(Request $request): View
    {
        $query = Comment::with('commentable')->latest();

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        // Filter by item type
        if ($request->has('item_type')) {
            $query->where('commentable_type', $request->item_type);
        }

        // Search by name or content
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $comments = $query->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment): View
    {
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
            'is_approved' => 'boolean',
        ]);

        $comment->update([
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'is_approved' => $request->has('is_approved'),
        ]);

        return redirect()->route('admin.comments.index')
                        ->with('success', 'Komentar berhasil diperbarui!');
    }

    /**
     * Approve the specified comment.
     */
    public function approve(Comment $comment): RedirectResponse
    {
        $comment->update(['is_approved' => true]);

        return redirect()->back()
                        ->with('success', 'Komentar berhasil disetujui!');
    }

    /**
     * Reject the specified comment.
     */
    public function reject(Comment $comment): RedirectResponse
    {
        $comment->update(['is_approved' => false]);

        return redirect()->back()
                        ->with('success', 'Komentar berhasil ditolak!');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
                        ->with('success', 'Komentar berhasil dihapus!');
    }

    /**
     * Bulk approve comments.
     */
    public function bulkApprove(Request $request): RedirectResponse
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->comment_ids)
               ->update(['is_approved' => true]);

        return redirect()->back()
                        ->with('success', count($request->comment_ids) . ' komentar berhasil disetujui!');
    }

    /**
     * Bulk reject comments.
     */
    public function bulkReject(Request $request): RedirectResponse
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->comment_ids)
               ->update(['is_approved' => false]);

        return redirect()->back()
                        ->with('success', count($request->comment_ids) . ' komentar berhasil ditolak!');
    }

    /**
     * Bulk delete comments.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->comment_ids)->delete();

        return redirect()->back()
                        ->with('success', count($request->comment_ids) . ' komentar berhasil dihapus!');
    }
}