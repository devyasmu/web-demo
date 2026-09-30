<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Download;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of downloads.
     */
    public function index(Request $request)
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();        
        $query = Download::where('is_active', true);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $downloads = $query->orderBy('created_at', 'desc')->paginate(12);
        
        return view('public.downloads.index', compact('downloads', 'siteSettings', "menus", "runningTexts"));
    }
    
    /**
     * Download the specified file.
     */
    public function download($id)
    {
        $download = Download::where('is_active', true)->findOrFail($id);

        $filePath = $this->resolveDownloadPath($download->file_path);

        if (!$filePath) {
            abort(404, 'File not found');
        }

        // Increment only after the file is confirmed to exist.
        $download->increment('download_count');

        return response()->download($filePath, $download->original_filename ?? $download->file_name);
    }

    private function resolveDownloadPath(string $path): ?string
    {
        $candidates = [
            storage_path('app/public/' . $path),
            public_path('storage/' . $path),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}
