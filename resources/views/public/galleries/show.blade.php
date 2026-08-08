@extends('layouts.public')

@section('title', $gallery->title . ' - Galeri - ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color: var(--primary-color);">Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('galleries.index') }}" style="color: var(--primary-color);">Galeri</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $gallery->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                @php($heroImage = $gallery->featured_image ?? $gallery->image ?? null)
                @if($heroImage)
                    <img src="{{ Storage::url($heroImage) }}" 
                         alt="{{ $gallery->title }}" 
                         class="card-img-top" style="height: 400px; object-fit: cover;">
                @endif

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="display-5 fw-bold mb-0" style="color: var(--primary-color);">
                            {{ $gallery->title }}
                        </h1>
                        @php($imagesColl = isset($images) ? $images : collect([]))
                        @php($containsHero = $heroImage ? $imagesColl->contains($heroImage) : false)
                        @php($imageCount = $imagesColl->count() + (($heroImage && !$containsHero) ? 1 : 0))
                        <span class="badge bg-primary fs-6">
                            <i class="bi bi-images me-1"></i>{{ $imageCount }} foto
                        </span>
                    </div>

                    @if($gallery->description)
                        <p class="lead text-muted mb-4">{{ $gallery->description }}</p>
                    @endif

                    @if($gallery->content)
                        <div class="mt-3">
                            {!! $gallery->content !!}
                        </div>
                    @endif

                    <small class="text-muted">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $gallery->created_at->format('d F Y') }}
                    </small>
                </div>
            </div>

            <!-- Gallery Images -->
            @php($images = collect($gallery->images ?? []))
            @if($images->count() > 0)
                <div class="row" id="gallery-grid">
                    @foreach($images as $image)
                        @php($imgPath = is_array($image) ? ($image['image_path'] ?? $image['image'] ?? '') : $image)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="gallery-item position-relative overflow-hidden rounded shadow-sm" 
                                 style="height: 250px; cursor: pointer;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#imageModal" 
                                 data-image="{{ Storage::url($imgPath) }}"
                                 data-title="{{ $gallery->title }}">
                                <img src="{{ Storage::url($imgPath) }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="w-100 h-100 object-cover">
                                <div class="position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center" 
                                     style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s ease;">
                                    <i class="bi bi-zoom-in text-white" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($heroImage)
                <div class="row" id="gallery-grid">
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="gallery-item position-relative overflow-hidden rounded shadow-sm" 
                             style="height: 250px; cursor: pointer;"
                             data-bs-toggle="modal" 
                             data-bs-target="#imageModal" 
                             data-image="{{ Storage::url($heroImage) }}"
                             data-title="{{ $gallery->title }}">
                            <img src="{{ Storage::url($heroImage) }}" 
                                 alt="{{ $gallery->title }}" 
                                 class="w-100 h-100 object-cover">
                            <div class="position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center" 
                                 style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s ease;">
                                <i class="bi bi-zoom-in text-white" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-images display-1 text-muted"></i>
                    <h3 class="mt-3">Belum ada foto dalam galeri ini</h3>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Galleries -->
    @if($relatedGalleries->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4" style="color: var(--primary-color);">
                    <i class="bi bi-collection me-2"></i>Galeri Lainnya
                </h3>
                <div class="row">
                    @foreach($relatedGalleries as $relatedGallery)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="card h-100 shadow-sm border-0">
                                @if($relatedGallery->featured_image)
                                    @php($relatedHero = $relatedGallery->featured_image ?? $relatedGallery->image ?? null)
                                    <div class="position-relative overflow-hidden" style="height: 150px;">
                                        <img src="{{ Storage::url($relatedHero) }}" 
                                             alt="{{ $relatedGallery->title }}" 
                                             class="card-img-top h-100 object-cover">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-dark bg-opacity-75">
                                                @php($relatedCount = ($relatedGallery->images_count ?? null))
                                                @php($relatedCount = $relatedCount ?: ($relatedHero ? 1 : 0))
                                                <i class="bi bi-images me-1"></i>{{ $relatedCount }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('galleries.show', $relatedGallery->slug) }}" 
                                           class="text-decoration-none" 
                                           style="color: var(--primary-color);">
                                            {{ Str::limit($relatedGallery->title, 30) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        {{ $relatedGallery->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Galeri Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<style>
.gallery-item:hover .position-absolute {
    opacity: 1 !important;
}

.object-cover {
    object-fit: cover;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: var(--primary-color);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalLabel');

    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image');
            const title = this.getAttribute('data-title');
            
            modalImage.src = imageSrc;
            modalImage.alt = title;
            modalTitle.textContent = title;
        });
    });
});
</script>
@endsection
