@extends('layouts.public')

@section('title', 'Artikel - ' . $siteSettings->site_name)
@section('description', 'Kumpulan artikel dan berita terbaru dari ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-newspaper me-3"></i>Artikel Terbaru
                </h1>
                <p class="lead text-muted">Temukan artikel dan berita terbaru dari yayasan kami</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('posts.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari artikel...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
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

    <!-- Posts Grid -->
    <div class="row">
        @forelse($posts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 modern-card">
                    @if($post->featured_image)
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ Storage::url($post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="card-img-top h-100 object-cover">
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($post->featured)
                                    <span class="badge bg-warning">
                                        <i class="bi bi-star-fill me-1"></i>Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge" style="background-color: var(--primary-color); color: white;">
                                {{ $post->category->name }}
                            </span>
                        </div>
                        
                        <h5 class="card-title fw-bold mb-3">
                            <a href="{{ route('posts.show', $post->slug) }}" 
                               class="text-decoration-none" 
                               style="color: var(--primary-color);">
                                {{ $post->title }}
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $post->published_at->format('d M Y') }}
                            </small>
                            <a href="{{ route('posts.show', $post->slug) }}" 
                               class="btn btn-sm" 
                               style="background-color: var(--primary-color); color: white;">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-newspaper display-1 text-muted"></i>
                    <h3 class="mt-3">Tidak ada artikel ditemukan</h3>
                    <p class="text-muted">Coba gunakan kata kunci lain atau filter yang berbeda</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Posts pagination">
                    {{ $posts->links('pagination::bootstrap-4') }}
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
