<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        $categories = Category::all();
        
        $query = Post::where('is_published', true)->with('category');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        $posts = $query->latest()->paginate(12);
        
        return view('public.posts.index', compact('posts', 'categories', 'siteSettings', 'menus', 'runningTexts'));
    }
    
    /**
     * Display the specified post.
     */
    public function show($slug)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        $post = Post::where('is_published', true)->where('slug', $slug)->with(['category', 'approvedComments'])->firstOrFail();
        
        // Get related posts (same category)
        $relatedPosts = Post::where('is_published', true)
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(3)
            ->get();
        
        // Get other posts (different articles)
        $otherPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(5)
            ->get();
        
        return view('public.posts.show', compact('post', 'relatedPosts', 'otherPosts', 'siteSettings', 'menus', 'runningTexts'));
    }
}
