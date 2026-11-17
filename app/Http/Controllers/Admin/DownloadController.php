<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    /** Jenis berkas yang boleh diunggah. */
    public const ALLOWED_TYPES = 'pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png';

    /** Batas ukuran berkas dalam KB (20 MB). */
    public const MAX_SIZE_KB = 20480;

    public function index()
    {
        $downloads = Download::with('category')->latest()->get();

        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.downloads.create', [
            'download' => new Download(['is_active' => true]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data += $this->storeFile($request->file('file'));

        Download::create($data);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File download berhasil ditambahkan.');
    }

    public function show(Download $download)
    {
        return redirect()->route('admin.downloads.edit', $download);
    }

    public function edit(Download $download)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.downloads.edit', compact('download', 'categories'));
    }

    public function update(Request $request, Download $download)
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('file')) {
            $oldPath = $download->file_path;
            $data += $this->storeFile($request->file('file'));
            $this->deleteFile($oldPath);
        }

        $download->update($data);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File download berhasil diperbarui.');
    }

    public function destroy(Download $download)
    {
        $this->deleteFile($download->file_path);
        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File download berhasil dihapus.');
    }

    private function validated(Request $request, bool $fileRequired): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'file' => [$fileRequired ? 'required' : 'nullable', 'file', 'mimes:' . self::ALLOWED_TYPES, 'max:' . self::MAX_SIZE_KB],
        ], [
            'file.required' => 'Pilih file yang akan diunggah.',
            'file.mimes' => 'Jenis file tidak didukung. Gunakan: ' . str_replace(',', ', ', self::ALLOWED_TYPES) . '.',
            'file.max' => 'Ukuran file maksimal ' . (self::MAX_SIZE_KB / 1024) . ' MB.',
            'file.uploaded' => 'File gagal diunggah. Kemungkinan ukurannya melebihi batas server.',
        ]);

        unset($data['file']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function storeFile(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'dokumen';

        return [
            'file_path' => $file->store('downloads', 'public'),
            'file_name' => $baseName . '.' . $extension,
            'file_type' => $extension,
            'file_size' => $file->getSize(),
        ];
    }

    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
