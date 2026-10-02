@extends('layouts.public')

@section('title', 'Program - ' . $siteSettings->site_name)
@section('description', 'Program-program pendidikan yang ditawarkan oleh ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-bookmark-star me-3"></i>Program Unggulan
                </h1>
                <p class="lead text-muted">Program-program terbaik yang kami tawarkan untuk kemajuan pendidikan</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('programs.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari program...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="featured" class="form-select">
                                <option value="">Semua Program</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Program Unggulan</option>
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

    <!-- Programs Grid -->
    <div class="row">
        @forelse($programs as $program)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 modern-card">
                    @if($program->featured_image)
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ Storage::url($program->featured_image) }}" 
                                 alt="{{ $program->title }}" 
                                 class="card-img-top h-100 object-cover">
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($program->is_featured)
                                    <span class="badge bg-warning">
                                        <i class="bi bi-star-fill me-1"></i>Unggulan
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        @if($program->duration)
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $program->duration }}</span>
                            </div>
                        @endif
                        
                        <h5 class="card-title fw-bold mb-3">
                            <a href="{{ route('programs.show', $program->slug) }}" 
                               class="text-decoration-none" 
                               style="color: var(--primary-color);">
                                {{ $program->title }}
                            </a>
                        </h5>
                        
                        @if($program->excerpt)
                            <p class="card-text text-muted flex-grow-1 public-readable-text">
                                {{ Str::limit($program->excerpt, 120) }}
                            </p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $program->created_at->format('d M Y') }}
                            </small>
                            <a href="{{ route('programs.show', $program->slug) }}" 
                               class="btn btn-sm" 
                               style="background-color: var(--primary-color); color: white;">
                                Detail Program
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-bookmark-star display-1 text-muted"></i>
                    <h3 class="mt-3">Tidak ada program ditemukan</h3>
                    <p class="text-muted">Coba gunakan kata kunci lain atau filter yang berbeda</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($programs->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Programs pagination">
                    {{ $programs->links('pagination::bootstrap-4') }}
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
