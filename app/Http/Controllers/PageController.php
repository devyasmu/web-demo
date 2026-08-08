<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the specified page.
     */
    public function show($slug)
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        
        return view('pages.show', compact('page', 'siteSettings', 'menus', 'runningTexts'));
    }

    /**
     * Display about page.
     */
    public function about()
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        
        return view('pages.about', compact('siteSettings', 'menus', 'runningTexts'));
    }

    /**
     * Display vision and mission page.
     */
    public function visionMission()
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        
        return view('pages.vision-mission', compact('siteSettings', 'menus', 'runningTexts'));
    }
}
