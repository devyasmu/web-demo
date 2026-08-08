<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;
class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        
        $query = Gallery::active();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $galleries = $query->ordered()->paginate(12);
        
        return view('public.galleries.index', compact('galleries', 'siteSettings', "menus", "runningTexts"));
    }
    
    /**
     * Display the specified gallery.
     */
    public function show($slug)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        $gallery = Gallery::active()->where('slug', $slug)->firstOrFail();
        
        // Get related galleries
        $relatedGalleries = Gallery::active()
            ->where('id', '!=', $gallery->id)
            ->ordered()
            ->limit(4)
            ->get();
        
        return view('public.galleries.show', compact('gallery', 'relatedGalleries', 'siteSettings', 'menus', 'runningTexts'));
    }
}
