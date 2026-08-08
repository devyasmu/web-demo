<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;
class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(Request $request)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();        
        $query = Testimonial::active();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('testimonial', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%');
            });
        }
        
        // Featured filter
        if ($request->has('featured') && $request->featured) {
            $query->featured();
        }
        
        $testimonials = $query->ordered()->paginate(12);
        
        return view('public.testimonials.index', compact('testimonials', 'siteSettings', "menus", "runningTexts"));
    }
}
