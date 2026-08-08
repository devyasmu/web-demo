<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs.
     */
    public function index(Request $request)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        
        $query = Program::active();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        // Featured filter
        if ($request->has('featured') && $request->featured) {
            $query->featured();
        }
        
        $programs = $query->ordered()->paginate(12);
        
        return view('public.programs.index', compact('programs', 'siteSettings', 'menus', 'runningTexts'));
    }
    
    /**
     * Display the specified program.
     */
    public function show($slug)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();
        $program = Program::active()->where('slug', $slug)->firstOrFail();
        
        // Get related programs
        $relatedPrograms = Program::active()
            ->where('id', '!=', $program->id)
            ->ordered()
            ->limit(4)
            ->get();
        
        return view('public.programs.show', compact('program', 'relatedPrograms', 'siteSettings', 'menus', 'runningTexts'));
    }
}
