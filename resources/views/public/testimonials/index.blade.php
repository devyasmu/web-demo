@extends('layouts.public')

@section('title', 'Testimoni - ' . $siteSettings->site_name)
@section('description', 'Testimoni dari wali murid dan siswa ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-chat-quote me-3"></i>Testimoni
                </h1>
                <p class="lead text-muted">Kata-kata dari mereka yang telah merasakan manfaat program kami</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('testimonials.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari testimoni...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="featured" class="form-select">
                                <option value="">Semua Testimoni</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Testimoni Unggulan</option>
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

    <!-- Testimonials Grid -->
    <div class="row">
        @forelse($testimonials as $testimonial)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 modern-card">
                    <div class="card-body p-4 d-flex flex-column">
                        <!-- Testimonial Header -->
                        <div class="d-flex align-items-center mb-3">
                            @if($testimonial->photo)
                                <img src="{{ Storage::url($testimonial->photo) }}" 
                                     alt="{{ $testimonial->name }}" 
                                     class="rounded-circle me-3" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background-color: var(--primary-color); color: white;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold" style="color: var(--primary-color);">
                                    {{ $testimonial->name }}
                                </h6>
                                @if($testimonial->position)
                                    <small class="text-muted">{{ $testimonial->position }}</small>
                                @endif
                            </div>
                            @if($testimonial->is_featured)
                                <span class="badge bg-warning">
                                    <i class="bi bi-star-fill me-1"></i>Unggulan
                                </span>
                            @endif
                        </div>

                        <!-- Rating -->
                        @if($testimonial->rating)
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="bi bi-star-fill text-warning me-1"></i>
                                        @else
                                            <i class="bi bi-star text-muted me-1"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2 text-muted">({{ $testimonial->rating }}/5)</span>
                                </div>
                            </div>
                        @endif

                        <!-- Testimonial Content -->
                        <div class="flex-grow-1">
                            <blockquote class="mb-3 testimonial-content" style="font-style: italic; color: var(--section-text-color);">
                                {{ trim(strip_tags($testimonial->testimonial)) }}
                            </blockquote>
                        </div>

                        <!-- Testimonial Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $testimonial->created_at->format('d M Y') }}
                            </small>
                            @if($testimonial->company)
                                <small class="text-muted">
                                    <i class="bi bi-building me-1"></i>
                                    {{ $testimonial->company }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-chat-quote display-1 text-muted"></i>
                    <h3 class="mt-3">Tidak ada testimoni ditemukan</h3>
                    <p class="text-muted">Coba gunakan kata kunci lain atau filter yang berbeda</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($testimonials->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Testimonials pagination">
                    {{ $testimonials->links('pagination::bootstrap-4') }}
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

blockquote {
    position: relative;
    padding-left: 1rem;
    border-left: 3px solid var(--primary-color);
    background-color: var(--section-bg-color);
    padding: 1rem;
    border-radius: 5px;
    margin: 0;
}

blockquote p {
    margin-bottom: 0;
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
