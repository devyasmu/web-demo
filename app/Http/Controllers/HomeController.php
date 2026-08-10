<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\RunningText;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Program;
use App\Models\Announcement;
use App\Models\Testimonial;
use App\Models\Statistic;
use App\Models\Feature;
use App\Models\QuickLink;
use App\Models\InstitutionContact;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index()
    {
        try {
            $siteSettings = SiteSetting::first();
            $sliders = Slider::active()->ordered()->limit(Slider::MAX_ITEMS)->get();
            $runningTexts = RunningText::active()->ordered()->get();
            $menus = Menu::active()->ordered()->get();
            
            // Paginated sections
            $featuredPosts = Post::published()->featured()->with('category')->latest()->paginate(6, ['*'], 'posts_page');
            $recentPosts = Post::published()->with('category')->latest()->paginate(4, ['*'], 'recent_page');
            $featuredPrograms = Program::active()->featured()->ordered()->paginate(6, ['*'], 'programs_page');
            $announcements = Announcement::active()->current()->latest()->paginate(5, ['*'], 'announcements_page');
            $testimonials = Testimonial::active()->featured()->ordered()->paginate(6, ['*'], 'testimonials_page');
            
            // New sections
            $statistics = Statistic::active()->ordered()->get();
            $features = Feature::active()->ordered()->get();
            $quickLinks = QuickLink::active()->ordered()->get();
            $institutionContacts = InstitutionContact::active()->ordered()->get();

            return view('home', compact(
                'siteSettings',
                'sliders', 
                'runningTexts',
                'menus',
                'featuredPosts',
                'recentPosts',
                'featuredPrograms',
                'announcements',
                'testimonials',
                'statistics',
                'features',
                'quickLinks',
                'institutionContacts'
            ));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Database connection error in HomeController: ' . $e->getMessage());
            
            // Return a fallback view with default data
            return view('home', [
                'siteSettings' => null,
                'sliders' => collect(),
                'runningTexts' => collect(),
                'menus' => collect(),
                'featuredPosts' => null,
                'recentPosts' => null,
                'featuredPrograms' => null,
                'announcements' => null,
                'testimonials' => null,
                'statistics' => collect(),
                'features' => collect(),
                'quickLinks' => collect(),
                'institutionContacts' => collect(),
                'error' => 'Database connection error. Please check your configuration.'
            ]);
        }
    }
}
