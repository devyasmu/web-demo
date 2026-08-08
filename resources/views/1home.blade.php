@extends('layouts.public')

@section('title', $siteSettings->site_name ?? 'Yayasan Pendidikan Islam')
@section('description', $siteSettings->site_description ?? 'Yayasan Pendidikan Islam yang berkomitmen untuk memberikan pendidikan berkualitas dengan nilai-nilai Islam yang kuat.')

@if(isset($error))
<div class="alert alert-danger" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>
    {{ $error }}
</div>
@endif

@section('content')
<!-- Modern Hero Section -->
@if($sliders && $sliders->count() > 0)
<section class="modern-hero" style="padding-bottom: 68px;">
    <div class="hero-background">
        <div class="hero-overlay"></div>
    </div>
    <div class="container position-relative" style="padding: 0 20px;">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators modern-indicators">
                @foreach($sliders as $index => $slider)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                            class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            
            <div class="carousel-inner">
                @foreach($sliders as $index => $slider)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row align-items-center min-vh-100">
                        <div class="col-lg-5">
                            <div class="hero-content modern-content">
                                <h1 class="hero-title">{{ $slider->title }}</h1>
                                @if($slider->description)
                                    <p class="hero-description">{{ $slider->description }}</p>
                                @endif
                                @if($slider->button_text && $slider->button_link)
                                    <div class="hero-buttons">
                                        <a href="{{ $slider->button_link }}" class="btn btn-modern-primary">
                                            <i class="bi bi-arrow-right me-2"></i>{{ $slider->button_text }}
                                        </a>
                                        <a href="#programs" class="btn btn-modern-primary">
                                            <i class="bi bi-play-circle me-2"></i>Lihat Program
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="hero-image-container">
                                @if($slider->image)
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="hero-image">
                                @else
                                    <div class="hero-placeholder">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                @endif
                                <div class="hero-shapes">
                                    <div class="shape-1"></div>
                                    <div class="shape-2"></div>
                                    <div class="shape-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <button class="carousel-control-prev modern-control" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next modern-control" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@else
<!-- Fallback Hero Section -->
<section class="modern-hero fallback-hero">
    <div class="hero-background">
        <div class="hero-overlay"></div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-5">
                <div class="hero-content modern-content">
                    <h1 class="hero-title">Selamat Datang di {{ $siteSettings->site_name ?? 'Yayasan Pendidikan Islam' }}</h1>
                    <p class="hero-description">{{ $siteSettings->site_description ?? 'Membangun generasi yang berakhlak mulia dan berprestasi dengan pendidikan Islam yang terintegrasi.' }}</p>
                    <div class="hero-buttons">
                        <a href="#programs" class="btn btn-modern-primary">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Program
                        </a>
                        <a href="{{ route('contacts.index') }}" class="btn btn-modern-primary">
                            <i class="bi bi-telephone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-image-container">
                    <div class="hero-placeholder">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="hero-shapes">
                        <div class="shape-1"></div>
                        <div class="shape-2"></div>
                        <div class="shape-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


<!-- Modern Features Section -->
<section class="modern-section features-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="bi bi-star"></i>
                        Keunggulan Kami
                    </div>
                    <h2 class="section-title">Mengapa Memilih Kami</h2>
                    <p class="section-description">Komitmen kami dalam memberikan pendidikan terbaik</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($features ?? collect() as $feature)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card-modern">
                    <div class="feature-icon">
                        <i class="{{ $feature->icon ?? 'bi bi-star' }}"></i>
                    </div>
                    <h3 class="feature-title">{{ $feature->title }}</h3>
                    <p class="feature-description">{{ $feature->description }}</p>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center">
                    <p>Belum ada data fitur. Silakan tambahkan melalui admin panel.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Modern Announcements Section -->
@if($announcements && $announcements->count() > 0)
<section class="modern-section announcements-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="bi bi-megaphone"></i>
                        <span>Pengumuman</span>
                    </div>
                    <h2 class="section-title">Informasi Terbaru</h2>
                    <p class="section-subtitle">Dapatkan informasi terkini tentang kegiatan dan program yayasan</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach($announcements as $announcement)
            <div class="col-md-6 col-lg-4">
                <div class="modern-card announcement-card">
                    <div class="card-header-modern">
                        <div class="priority-badge priority-{{ $announcement->priority }}">
                            <i class="bi bi-{{ $announcement->priority === 'urgent' ? 'exclamation-triangle' : ($announcement->priority === 'high' ? 'star' : 'info-circle') }}"></i>
                            <span>{{ ucfirst($announcement->priority) }}</span>
                        </div>
                        <div class="date-badge">
                            {{ $announcement->created_at->format('d M') }}
                        </div>
                    </div>
                    <div class="card-body-modern">
                        <h5 class="card-title-modern">{{ $announcement->title }}</h5>
                        <p class="card-text-modern">{{ Str::limit(strip_tags($announcement->content), 120) }}</p>
                        <div class="card-footer-modern">
                            <a href="{{ \App\Helpers\RouteHelper::safeRouteWithMessage('announcements.show', $announcement->slug ?? '', 'Detail pengumuman tidak tersedia') }}" class="btn-read-more">
                                <span>Baca Selengkapnya</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination for Announcements -->
        @if($announcements && $announcements->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Announcements pagination">
                    {{ $announcements->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</section>
@endif

<!-- Modern Programs Section -->
@if($featuredPrograms && $featuredPrograms->count() > 0)
<section id="programs" class="modern-section programs-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="bi bi-mortarboard"></i>
                        <span>Program</span>
                    </div>
                    <h2 class="section-title">Program Unggulan</h2>
                    <p class="section-subtitle">Program pendidikan berkualitas dengan pendekatan Islam yang terintegrasi</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach($featuredPrograms as $program)
            <div class="col-md-6 col-lg-4">
                <div class="modern-card program-card">
                    <div class="card-image-container">
                        @if($program->featured_image)
                            <img src="{{ asset('storage/' . $program->featured_image) }}" alt="{{ $program->title }}" class="card-image">
                        @else
                            <div class="card-image-placeholder">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                        @endif
                        <div class="card-overlay">
                            <div class="overlay-content">
                                <a href="{{ \App\Helpers\RouteHelper::safeRouteWithMessage('programs.show', $program->slug ?? '', 'Detail program tidak tersedia') }}" class="btn-overlay">
                                    <i class="bi bi-eye"></i>
                                    <span>Lihat Detail</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-modern">
                        <div class="program-category">
                            <i class="bi bi-book"></i>
                            <span>Program Pendidikan</span>
                        </div>
                        <h5 class="card-title-modern">{{ $program->title }}</h5>
                        @if($program->excerpt)
                            <p class="card-text-modern">{{ $program->excerpt }}</p>
                        @endif
                        <div class="card-footer-modern">
                            <div class="program-price">
                                @if($program->price)
                                    <span class="price-amount">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                                    <span class="price-period">/bulan</span>
                                @else
                                    <span class="price-free">Gratis</span>
                                @endif
                            </div>
                            <a href="{{ \App\Helpers\RouteHelper::safeRouteWithMessage('programs.show', $program->slug ?? '', 'Detail program tidak tersedia') }}" class="btn-modern-card">
                                <span>Lihat Detail</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <a href="{{ route('programs.index') }}" class="btn btn-modern-outline-large">
                    <i class="bi bi-grid me-2"></i>
                    Lihat Semua Program
                </a>
            </div>
        </div>
        
        <!-- Pagination for Programs -->
        @if($featuredPrograms && $featuredPrograms->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Programs pagination">
                    {{ $featuredPrograms->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</section>
@endif

<!-- Modern Posts Section -->
@if($featuredPosts && $featuredPosts->count() > 0)
<section class="modern-section posts-section">
<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="bi bi-newspaper"></i>
                        <span>Artikel</span>
                    </div>
                    <h2 class="section-title">Artikel Terbaru</h2>
                    <p class="section-subtitle">Kumpulan artikel dan berita terkini seputar pendidikan dan kegiatan yayasan</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach($featuredPosts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="modern-card post-card">
                    <div class="card-image-container">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="card-image">
                        @else
                            <div class="card-image-placeholder">
                                <i class="bi bi-newspaper"></i>
                            </div>
                        @endif
                        <div class="card-overlay">
                            <div class="overlay-content">
                                <a href="{{ \App\Helpers\RouteHelper::safeRouteWithMessage('posts.show', $post->slug ?? '', 'Detail artikel tidak tersedia') }}" class="btn-overlay">
                                    <i class="bi bi-eye"></i>
                                    <span>Baca Artikel</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-modern">
                        <div class="post-meta">
                            <span class="category-badge" style="background-color: {{ $post->category->color }} }};">
                                {{ $post->category->name }}
                            </span>
                            <span class="post-date">{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <h5 class="card-title-modern">{{ $post->title }}</h5>
                        @if($post->excerpt)
                            <p class="card-text-modern">{{ $post->excerpt }}</p>
                        @endif
                        <div class="card-footer-modern">
                            <a href="{{ \App\Helpers\RouteHelper::safeRouteWithMessage('posts.show', $post->slug ?? '', 'Detail artikel tidak tersedia') }}" class="btn-read-more">
                                <span>Baca Selengkapnya</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <a href="{{ route('posts.index') }}" class="btn btn-modern-outline-large">
                    <i class="bi bi-newspaper me-2"></i>
                    Lihat Semua Artikel
                </a>
            </div>
        </div>
        
        <!-- Pagination for Posts -->
        @if($featuredPosts && $featuredPosts->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Posts pagination">
                    {{ $featuredPosts->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</section>
@endif

<!-- Modern Stats Section -->
<section class="modern-section stats-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="bi bi-graph-up"></i>
                        Statistik Yayasan
                    </div>
                    <h2 class="section-title">Pencapaian Kami</h2>
                    <p class="section-description">Membangun kepercayaan melalui prestasi dan dedikasi</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($statistics ?? collect() as $statistic)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card-modern">
                    <div class="stat-icon">
                        <i class="{{ $statistic->icon ?? 'bi bi-graph-up' }}"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $statistic->value }}</div>
                        <div class="stat-label">{{ $statistic->title }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center text-white">
                    <p>Belum ada data statistik. Silakan tambahkan melalui admin panel.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Modern Testimonials Section -->
@if($testimonials && $testimonials->count() > 0)
<section class="modern-section testimonials-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="bi bi-quote"></i>
                        <span>Testimoni</span>
                    </div>
                    <h2 class="section-title">Kata Mereka</h2>
                    <p class="section-subtitle">Pengalaman dan kesan dari orang tua dan siswa yang telah bergabung</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4">
                <div class="modern-card testimonial-card">
                    <div class="card-body-modern text-center">
                        <div class="testimonial-avatar">
                            @if($testimonial->photo)
                                <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}" class="avatar-image">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif
                        </div>
                        <div class="testimonial-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <blockquote class="testimonial-quote">
                            "{{ $testimonial->testimonial }}"
                        </blockquote>
                        <div class="testimonial-author">
                            <h6 class="author-name">{{ $testimonial->name }}</h6>
                            @if($testimonial->position || $testimonial->company)
                                <p class="author-title">{{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ' - ' : '' }}{{ $testimonial->company }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination for Testimonials -->
        @if($testimonials && $testimonials->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Testimonials pagination">
                    {{ $testimonials->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</section>
                    @endif

<!-- Modern CTA Section -->
<section class="modern-cta">
    <div class="cta-background">
        <div class="cta-overlay"></div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="cta-content">
                    <h2 class="cta-title">Bergabunglah dengan Kami</h2>
                    <p class="cta-description">Daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik dengan nilai-nilai Islam yang kuat dan terintegrasi.</p>
                    <div class="cta-features">
                        <div class="feature-item">
                            <i class="bi bi-check-circle"></i>
                            <span>Pendidikan Berkualitas</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle"></i>
                            <span>Nilai Islam Terintegrasi</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle"></i>
                            <span>Guru Berpengalaman</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cta-actions">
                    <a href="{{ route('contacts.index') }}" class="btn btn-modern-primary-large">
                        <i class="bi bi-telephone me-2"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Modern Hero Section */
.modern-hero {
    position: relative;
    min-height: 80vh;
    max-height: 90vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
    z-index: -2;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    z-index: -1;
}

.hero-content {
    z-index: 2;
    position: relative;
}

.hero-badge {
    display: inline-block;
}

.badge-modern {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}

.btn-modern-primary {
    background: var(--button-primary-color, #007bff);
    color: var(--button-text-color, #ffffff);
    border: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-modern-primary:hover {
    background: var(--button-primary-hover, #0056b3);
    color: var(--button-text-color, #ffffff);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.btn-modern-outline {
    background: transparent;
    color: var(--button-outline-color, #ffffff);
    border: 2px solid var(--button-outline-color, rgba(255, 255, 255, 0.5));
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-modern-outline:hover {
    background: var(--button-primary-color, rgba(255, 255, 255, 0.1));
    border-color: var(--button-primary-color, #ffffff);
    color: var(--button-text-color, #ffffff);
    transform: translateY(-2px);
}

.hero-image-container {
    position: relative;
    z-index: 2;
    aspect-ratio: 16 / 9; /* keep nice ratio on desktop */
}

.hero-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.hero-placeholder {
    width: 100%;
    height: 500px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-placeholder i {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.7);
}

.hero-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
}

.shape-1, .shape-2, .shape-3 {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 100px;
    height: 100px;
    top: 20%;
    right: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 60px;
    height: 60px;
    top: 60%;
    left: 5%;
    animation-delay: 2s;
}

.shape-3 {
    width: 80px;
    height: 80px;
    bottom: 20%;
    right: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Mobile optimizations: avoid image cropping */
@media (max-width: 576px) {
    /* Give space under the sticky header so the top of the slider is visible */
    .modern-hero { padding-top: 100px; }
    .carousel-item .row.align-items-center.min-vh-100 {
        min-height: auto !important;
    }
    .hero-image-container {
        aspect-ratio: auto;
    }
    .hero-image {
        height: auto;
        max-height: 55vh;
        object-fit: contain; /* keep full image visible */
        background: #f5f7fb; /* subtle background to fill space */
    }
    .hero-placeholder {
        height: 40vh;
    }
    .hero-title { font-size: 2rem; }
    .hero-description { font-size: 1rem; }
    .hero-buttons { margin-bottom: 1.5rem; }
}

/* Modern Carousel Controls */
.modern-indicators {
    bottom: 2rem;
}

.modern-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.modern-indicators button.active {
    background: white;
    transform: scale(1.2);
}

.modern-control {
    width: 50px;
    height: 50px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    z-index: 15;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.modern-control:hover {
    background: rgba(0, 0, 0, 0.5);
    border-color: white;
    transform: translateY(-50%) scale(1.1);
}

.modern-control .carousel-control-prev-icon,
.modern-control .carousel-control-next-icon {
    width: 0;
    height: 0;
    background: none;
    border: none;
    position: relative;
}

.modern-control .carousel-control-prev-icon::before {
    content: '<';
    font-size: 24px;
    font-weight: bold;
    color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.modern-control .carousel-control-next-icon::before {
    content: '>';
    font-size: 24px;
    font-weight: bold;
    color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Desktop carousel controls positioning */
.carousel-control-prev {
    left: -30px !important;
}

.carousel-control-next {
    right: -30px !important;
}

/* Ensure controls are completely outside slide area */
.carousel-control-prev,
.carousel-control-next {
    margin: 0 !important;
    padding: 0 !important;
    width: 50px !important;
    height: 50px !important;
}

/* Additional positioning to ensure buttons are outside */
.modern-hero .carousel-control-prev {
    left: -30px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
}

.modern-hero .carousel-control-next {
    right: -30px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
}

/* Mobile carousel controls */
@media (max-width: 768px) {
    .modern-control {
        width: 40px !important;
        height: 40px !important;
        background: rgba(0, 0, 0, 0.3) !important;
        border: 2px solid rgba(255, 255, 255, 0.8) !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s ease !important;
    }
    
    .modern-control:hover {
        background: rgba(0, 0, 0, 0.5) !important;
        border-color: white !important;
        transform: scale(1.1) !important;
    }
    
    .modern-control .carousel-control-prev-icon::before,
    .modern-control .carousel-control-next-icon::before {
        font-size: 20px !important;
    }
    
    /* Position controls outside slide area on mobile */
    .carousel-control-prev {
        left: -10px !important;
    }
    
    .carousel-control-next {
        right: -10px !important;
    }
    
    /* Reduce container padding on mobile */
    .modern-hero .container {
        padding: 0 20px !important;
    }
}

/* Modern Sections */
.modern-section {
    padding: 3rem 0;
    position: relative;
    background-color: var(--section-bg-color, #f8f9fa);
    color: var(--section-text-color, #333);
}

/* Stats Section */
.stats-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
}

.stats-section .section-title,
.stats-section .section-description {
    color: white;
}

.stat-card-modern {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card-modern:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    font-size: 3rem;
    color: white;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

/* Features Section */
.features-section {
    background-color: white;
}

.feature-card-modern {
    background: white;
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.feature-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-color, #333);
    margin-bottom: 1rem;
}

.feature-description {
    color: var(--text-muted, #666);
    line-height: 1.6;
    font-size: 1rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--badge-bg-color, var(--primary-color));
    color: var(--badge-text-color, #ffffff);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: var(--section-text-color, #666);
    max-width: 600px;
    margin: 0 auto;
}

/* Modern Cards */
.modern-card {
    background: var(--card-bg-color, #ffffff);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid var(--card-border-color, rgba(0, 0, 0, 0.05));
    height: 100%;
}

.modern-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.card-image-container {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.modern-card:hover .card-image {
    transform: scale(1.05);
}

.card-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.modern-card:hover .card-overlay {
    opacity: 1;
}

.btn-overlay {
    background: var(--card-button-bg, #ffffff);
    color: var(--card-button-text, var(--primary-color));
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-overlay:hover {
    background: var(--card-button-hover-bg, #f8f9fa);
    color: var(--card-button-hover-text, var(--primary-color));
    transform: scale(1.05);
}

.card-body-modern {
    padding: 2rem;
}

.card-title-modern {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--section-text-color, #333);
    margin-bottom: 1rem;
    line-height: 1.4;
}

.card-text-modern {
    color: var(--section-text-color, #666);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.card-footer-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.btn-read-more {
    color: var(--link-color, var(--primary-color));
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-read-more:hover {
    color: var(--link-hover-color, var(--primary-color));
    transform: translateX(5px);
}

/* Program Cards */
.program-category {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.program-price {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
}

.price-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

.price-period {
    color: var(--section-text-color, #666);
    font-size: 0.9rem;
}

.price-free {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 1.1rem;
}

.btn-modern-card {
    background: var(--card-button-bg, var(--primary-color));
    color: var(--card-button-text, #ffffff);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-modern-card:hover {
    background: var(--card-button-hover-bg, var(--secondary-color));
    color: var(--card-button-hover-text, #ffffff);
    transform: translateY(-2px);
}

/* Announcement Cards */
.card-header-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem 0;
}

.priority-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.priority-urgent {
    background: #fee;
    color: #dc3545;
}

.priority-high {
    background: #fff3cd;
    color: #856404;
}

.priority-normal {
    background: #d1ecf1;
    color: #0c5460;
}

.date-badge {
    background: var(--card-bg-color, #f8f9fa);
    color: var(--section-text-color, #666);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Post Cards */
.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.category-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
}

.post-date {
    color: var(--section-text-color, #666);
    font-size: 0.9rem;
}

/* Testimonial Cards */
.testimonial-avatar {
    margin-bottom: 1.5rem;
}

.avatar-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto;
}

.testimonial-rating {
    margin-bottom: 1rem;
}

.testimonial-rating i {
    color: #ffc107;
    font-size: 1.2rem;
    margin: 0 0.1rem;
}

.testimonial-quote {
    font-style: italic;
    color: var(--section-text-color, #666);
    margin-bottom: 1.5rem;
    line-height: 1.6;
    font-size: 1.1rem;
}

.author-name {
    font-weight: 700;
    color: var(--section-text-color, #333);
    margin-bottom: 0.25rem;
}

.author-title {
    color: var(--section-text-color, #666);
    font-size: 0.9rem;
    margin: 0;
}

/* Modern CTA */
.modern-cta {
    position: relative;
    padding: 5rem 0;
    overflow: hidden;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    z-index: -2;
}

.cta-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    z-index: -1;
}

.cta-content {
    color: white;
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: white;
}

.cta-description {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
}

.cta-features {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    font-weight: 500;
}

.feature-item i {
    color: var(--accent-color);
    font-size: 1.2rem;
}

.cta-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-modern-primary-large {
    background: var(--button-primary-color, #ffffff);
    color: var(--button-text-color, var(--primary-color));
    padding: 1.25rem 2.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-modern-primary-large:hover {
    background: var(--button-primary-hover, #0056b3);
    color: var(--button-text-color, #ffffff);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.btn-modern-outline-large {
    background: linear-gradient(135deg, var(--button-primary-color, var(--primary-color)) 0%, var(--button-secondary-color, var(--secondary-color)) 100%);
    color: var(--button-text-color, #ffffff);
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: auto;
    max-width: fit-content;
}

.btn-modern-outline-large:hover {
    background: linear-gradient(135deg, var(--button-primary-hover, var(--secondary-color)) 0%, var(--button-secondary-hover, var(--primary-color)) 100%);
    color: var(--button-text-color, #ffffff);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-buttons {
        flex-direction: column;
    }
    
    .cta-features {
        flex-direction: column;
        gap: 1rem;
    }
    
    .cta-actions {
        margin-top: 2rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .modern-card {
        margin-bottom: 2rem;
    }
}

/* Pagination Styles */
.pagination {
    justify-content: center;
    margin-top: 2rem;
}

.pagination .page-link {
    color: var(--link-color, var(--primary-color));
    border-color: var(--link-color, var(--primary-color));
    border-radius: 50px;
    margin: 0 0.25rem;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background-color: var(--link-hover-color, var(--primary-color));
    color: var(--button-text-color, #ffffff);
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background-color: var(--link-hover-color, var(--primary-color));
    border-color: var(--link-hover-color, var(--primary-color));
    color: var(--button-text-color, #ffffff);
}

.pagination .page-item.disabled .page-link {
    color: var(--section-text-color, #6c757d);
    border-color: var(--card-border-color, #dee2e6);
}
</style>
@endpush

@push('scripts')
<script>
// Auto-hide alerts after 5 seconds
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);

// Ensure carousel works on mobile
document.addEventListener('DOMContentLoaded', function() {
    // Initialize carousel manually
    const carouselElement = document.querySelector('#heroCarousel');
    if (carouselElement) {
        // Initialize Bootstrap carousel (with Bootstrap check)
        if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
            const carousel = new bootstrap.Carousel(carouselElement, {
                interval: 5000,
                wrap: true,
                touch: true
            });
        } else {
            console.warn('Bootstrap Carousel not available');
        }
        
        // Add touch/swipe support for mobile
        let startX = 0;
        let startY = 0;
        let endX = 0;
        let endY = 0;
        
        carouselElement.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        carouselElement.addEventListener('touchend', function(e) {
            endX = e.changedTouches[0].clientX;
            endY = e.changedTouches[0].clientY;
            
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            // Only trigger if horizontal swipe is more significant than vertical
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    // Swipe left - next slide
                    carousel.next();
                } else {
                    // Swipe right - previous slide
                    carousel.prev();
                }
            }
        });
        
        // Ensure control buttons work
        const prevButton = carouselElement.querySelector('.carousel-control-prev');
        const nextButton = carouselElement.querySelector('.carousel-control-next');
        
        if (prevButton) {
            prevButton.addEventListener('click', function(e) {
                e.preventDefault();
                carousel.prev();
            });
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', function(e) {
                e.preventDefault();
                carousel.next();
            });
        }
    }
});
</script>
@endpush