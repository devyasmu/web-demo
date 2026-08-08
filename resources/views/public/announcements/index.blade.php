@extends('layouts.public')

@section('title', 'Pengumuman - ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-megaphone me-3"></i>Pengumuman
                </h1>
                <p class="lead text-muted">Informasi dan pengumuman terbaru dari yayasan</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('announcements.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari pengumuman...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="priority" class="form-select">
                                <option value="">Semua Prioritas</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Prioritas Tinggi</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Prioritas Sedang</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Prioritas Rendah</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="row">
        @forelse($announcements as $announcement)
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0 modern-card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            @if($announcement->priority == 'high')
                                                <span class="badge bg-danger me-2">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>Prioritas Tinggi
                                                </span>
                                            @elseif($announcement->priority == 'medium')
                                                <span class="badge bg-warning me-2">
                                                    <i class="bi bi-info-circle-fill me-1"></i>Prioritas Sedang
                                                </span>
                                            @else
                                                <span class="badge bg-info me-2">
                                                    <i class="bi bi-info-circle me-1"></i>Prioritas Rendah
                                                </span>
                                            @endif
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->translatedFormat('d F Y') : '-' }}
                                            </small>
                                        </div>
                                        
                                        <h4 class="card-title fw-bold mb-3">
                                            <a href="{{ route('announcements.show', $announcement->slug) }}" 
                                               class="text-decoration-none" 
                                               style="color: var(--primary-color);">
                                                {{ $announcement->title }}
                                            </a>
                                        </h4>
                                        
                                        @if($announcement->excerpt)
                                            <p class="card-text text-muted mb-3">
                                                {{ $announcement->excerpt }}
                                            </p>
                                        @endif
                                        
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('announcements.show', $announcement->slug) }}" 
                                               class="btn btn-sm me-3" 
                                               style="background-color: var(--primary-color); color: white;">
                                                Baca Selengkapnya
                                            </a>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('H:i') : '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($announcement->featured_image)
                                <div class="col-md-4">
                                    <img src="{{ Storage::url($announcement->featured_image) }}" 
                                         alt="{{ $announcement->title }}" 
                                         class="img-fluid rounded" 
                                         style="height: 150px; object-fit: cover; width: 100%;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-megaphone display-1 text-muted"></i>
                    <h3 class="mt-3">Tidak ada pengumuman ditemukan</h3>
                    <p class="text-muted">Coba gunakan kata kunci lain atau filter yang berbeda</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($announcements->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Announcements pagination">
                    {{ $announcements->links('pagination::bootstrap-4') }}
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
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
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
@endsection
