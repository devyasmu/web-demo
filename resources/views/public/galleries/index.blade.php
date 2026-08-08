@extends('layouts.public')

@section('title', 'Galeri - ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-images me-3"></i>Galeri Foto
                </h1>
                <p class="lead text-muted">Koleksi foto dan dokumentasi kegiatan yayasan</p>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('galleries.index') }}" class="row g-3">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari galeri...">
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

    <!-- Galleries Grid -->
    <div class="row">
        @forelse($galleries as $gallery)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 modern-card">
                    @php($cardImage = $gallery->featured_image ?? $gallery->image ?? null)
                    @if($cardImage)
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img src="{{ Storage::url($cardImage) }}" 
                                 alt="{{ $gallery->title }}" 
                                 class="card-img-top h-100 object-cover">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-dark bg-opacity-75">
                                    @php($imgs = is_array($gallery->images ?? null) ? $gallery->images : [])
                                    @php($containsHero = $cardImage ? in_array($cardImage, $imgs, true) : false)
                                    @php($count = count($imgs) + (($cardImage && !$containsHero) ? 1 : 0))
                                    <i class="bi bi-images me-1"></i>{{ $count }} foto
                                </span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 end-0 p-3" 
                                 style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                                <h5 class="text-white mb-0">{{ $gallery->title }}</h5>
                            </div>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-3">
                            <a href="{{ route('galleries.show', $gallery->slug) }}" 
                               class="text-decoration-none" 
                               style="color: var(--primary-color);">
                                {{ $gallery->title }}
                            </a>
                        </h5>
                        
                        @if($gallery->description)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($gallery->description, 120) }}
                            </p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $gallery->created_at->format('d M Y') }}
                            </small>
                            <a href="{{ route('galleries.show', $gallery->slug) }}" 
                               class="btn btn-sm" 
                               style="background-color: var(--primary-color); color: white;">
                                <i class="bi bi-eye me-1"></i>Lihat Galeri
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-images display-1 text-muted"></i>
                    <h3 class="mt-3">Tidak ada galeri ditemukan</h3>
                    <p class="text-muted">Coba gunakan kata kunci lain</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Galleries pagination">
                    {{ $galleries->links('pagination::bootstrap-4') }}
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

.object-cover {
    object-fit: cover;
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
