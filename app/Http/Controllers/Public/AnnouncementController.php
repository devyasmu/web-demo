<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index(Request $request)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();        
        $query = Announcement::active()->current();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        // Priority filter
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }
        
        $announcements = $query->latest()->paginate(12);
        
        return view('public.announcements.index', compact('announcements', 'siteSettings', "menus", "runningTexts"));
    }
    
    /**
     * Display the specified announcement.
     */
    public function show($slug)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();        $announcement = Announcement::active()->where('slug', $slug)->firstOrFail();
        
        // Get related announcements
        $relatedAnnouncements = Announcement::active()
            ->where('id', '!=', $announcement->id)
            ->latest()
            ->limit(4)
            ->get();
        
        return view('public.announcements.show', compact('announcement', 'relatedAnnouncements', 'siteSettings', "menus", "runningTexts"));
    }
}
