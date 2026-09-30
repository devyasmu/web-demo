<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Category;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    /**
     * Display a listing of downloads.
     */
    public function index(Request $request)
    {
        $query = Download::with('category')->active();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $downloads = $query->latest()->paginate(12);
        $categories = Category::active()->get();

        return view('downloads.index', compact('downloads', 'categories'));
    }

    /**
     * Download a file.
     */
    public function download($id)
    {
        $download = Download::active()->findOrFail($id);

        $filePath = $this->resolveDownloadPath($download->file_path);

        if (!$filePath) {
            abort(404, 'File not found');
        }

        // Increment only after the file is confirmed to exist.
        $download->increment('download_count');

        return response()->download($filePath, $download->file_name);
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
