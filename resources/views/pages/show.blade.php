@extends('layouts.public')

@section('title', ($page->meta_title ?: $page->title) . ' - ' . ($siteSettings->site_name ?? config('app.name')))
@section('description', $page->meta_description ?: Str::limit(strip_tags($page->content), 160))

@section('content')
<!-- Modern Hero Section -->
<section class="modern-hero-page">
    <div class="hero-background">
        <div class="hero-overlay"></div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content modern-content">
                    <div class="hero-badge mb-3">
                        <span class="badge-modern">Informasi</span>
                    </div>
                    <h1 class="hero-title">{{ $page->title }}</h1>
                    @if($page->meta_description)
                        <p class="hero-description">{{ $page->meta_description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modern Page Content -->
<section class="modern-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb modern-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                    </ol>
                </nav>

                <!-- Page Content -->
                <article class="modern-page-card">
                    <div class="card-body-modern">
                        <!-- Content -->
                        <div class="page-content">
                            {!! $page->content !!}
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Modern Hero Page */
.modern-hero-page {
    position: relative;
    min-height: 50vh;
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
    font-size: 3rem;
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

/* Modern Page Card */
.modern-page-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
}

.card-body-modern {
    padding: 3rem;
}

/* Modern Breadcrumb */
.modern-breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.modern-breadcrumb .breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.modern-breadcrumb .breadcrumb-item.active {
    color: #666;
    font-weight: 600;
}

/* Page Content Styles */
.page-content {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #333;
}

.page-content h1,
.page-content h2,
.page-content h3,
.page-content h4,
.page-content h5,
.page-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--primary-color);
}

.page-content h1 {
    font-size: 2.5rem;
    border-bottom: 3px solid var(--primary-color);
    padding-bottom: 0.5rem;
    position: relative;
}

.page-content h1::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--accent-color);
}

.page-content h2 {
    font-size: 2rem;
    color: var(--primary-color);
    position: relative;
    padding-left: 1rem;
}

.page-content h2::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 30px;
    background: var(--accent-color);
    border-radius: 2px;
}

.page-content h3 {
    font-size: 1.5rem;
    color: var(--secondary-color);
}

.page-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
    color: #555;
}

.page-content img {
    max-width: 100%;
    height: auto;
    border-radius: 15px;
    margin: 1.5rem 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.page-content img:hover {
    transform: scale(1.02);
}

.page-content ul,
.page-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.page-content li {
    margin-bottom: 0.75rem;
    color: #555;
}

.page-content blockquote {
    border-left: 4px solid var(--primary-color);
    padding: 1.5rem 2rem;
    margin: 2rem 0;
    font-style: italic;
    background: linear-gradient(135deg, rgba(var(--primary-color-rgb, 0, 123, 255), 0.05), rgba(var(--secondary-color-rgb, 108, 117, 125), 0.05));
    border-radius: 0 15px 15px 0;
    position: relative;
}

.page-content blockquote::before {
    content: '"';
    position: absolute;
    top: -10px;
    left: 20px;
    font-size: 4rem;
    color: var(--primary-color);
    opacity: 0.3;
    font-family: serif;
}

.page-content table {
    width: 100%;
    margin-bottom: 2rem;
    border-collapse: collapse;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.page-content table th,
.page-content table td {
    padding: 1rem;
    border: 1px solid #e9ecef;
}

.page-content table th {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    font-weight: 600;
    text-align: left;
}

.page-content table tr:nth-child(even) {
    background-color: #f8f9fa;
}

.page-content table tr:hover {
    background-color: rgba(var(--primary-color-rgb, 0, 123, 255), 0.05);
}

.page-content .highlight {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    padding: 1.5rem;
    border-radius: 15px;
    border-left: 4px solid var(--accent-color);
    margin: 1.5rem 0;
    position: relative;
}

.page-content .highlight::before {
    content: '💡';
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 1.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .card-body-modern {
        padding: 2rem;
    }
    
    .page-content h1 {
        font-size: 2rem;
    }
    
    .page-content h2 {
        font-size: 1.5rem;
    }
}
</style>
@endpush
@endsection
