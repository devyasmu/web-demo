@extends('layouts.public')

@section('title', 'Download - ' . $siteSettings->site_name)
@section('description', 'Unduh dokumen dan berkas penting dari ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-download me-3"></i>Download
                </h1>
                <p class="lead text-muted">Dokumen dan file yang dapat diunduh</p>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('downloads.index') }}" class="row g-3">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari file...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Downloads List -->
    <div class="row">
        @forelse($downloads as $download)
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 modern-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                @if($download->file_type == 'pdf')
                                    <i class="bi bi-file-pdf text-danger" style="font-size: 2.5rem;"></i>
                                @elseif($download->file_type == 'doc' || $download->file_type == 'docx')
                                    <i class="bi bi-file-word text-primary" style="font-size: 2.5rem;"></i>
                                @elseif($download->file_type == 'xls' || $download->file_type == 'xlsx')
                                    <i class="bi bi-file-excel text-success" style="font-size: 2.5rem;"></i>
                                @elseif($download->file_type == 'ppt' || $download->file_type == 'pptx')
                                    <i class="bi bi-file-ppt text-warning" style="font-size: 2.5rem;"></i>
                                @elseif($download->file_type == 'zip' || $download->file_type == 'rar')
                                    <i class="bi bi-file-zip text-secondary" style="font-size: 2.5rem;"></i>
                                @else
                                    <i class="bi bi-file-earmark text-muted" style="font-size: 2.5rem;"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-2" style="color: var(--primary-color);">
                                    {{ $download->title }}
                                </h5>
                                
                                @if($download->description)
                                    <p class="card-text text-muted mb-3 public-readable-text">
                                        {{ Str::limit($download->description, 100) }}
                                    </p>
                                @endif
                                
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted me-3">
                                            <i class="bi bi-download me-1"></i>
                                            {{ $download->download_count }} kali
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $download->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-light text-dark me-2">
                                    {{ strtoupper($download->file_type) }}
                                </span>
                                <small class="text-muted">
                                    {{ number_format($download->file_size / 1024, 1) }} KB
                                </small>
                            </div>
                            <a href="{{ route('downloads.download', $download->id) }}" 
                               class="btn btn-sm" 
                               style="background-color: var(--primary-color); color: white;"
                               onclick="incrementDownload({{ $download->id }})">
                                <i class="bi bi-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-download display-1 text-muted"></i>
                    <h3 class="mt-3">Tidak ada file ditemukan</h3>
                    <p class="text-muted">Coba gunakan kata kunci lain</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($downloads->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Downloads pagination">
                    {{ $downloads->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    @endif
</div>

<style>
.modern-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.pagination .page-link {
    color: var(--primary-color);
    border-color: var(--primary-color);
    border-radius: 50px;
    margin: 0 0.25rem;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}
</style>

<script>
function incrementDownload(downloadId) {
    // Optional: Add analytics or tracking here
}
</script>
@endsection
