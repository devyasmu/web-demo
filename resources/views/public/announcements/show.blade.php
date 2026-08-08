@extends('layouts.public')

@section('title', $announcement->title . ' - Pengumuman - ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color: var(--primary-color);">Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('announcements.index') }}" style="color: var(--primary-color);">Pengumuman</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $announcement->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card shadow-sm border-0">
                @if($announcement->featured_image)
                    <img src="{{ Storage::url($announcement->featured_image) }}" 
                         alt="{{ $announcement->title }}" 
                         class="card-img-top" style="height: 400px; object-fit: cover;">
                @endif

                <div class="card-body p-4">
                    <!-- Announcement Meta -->
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        @if($announcement->priority == 'high')
                            <span class="badge bg-danger me-2 mb-2">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>Prioritas Tinggi
                            </span>
                        @elseif($announcement->priority == 'medium')
                            <span class="badge bg-warning me-2 mb-2">
                                <i class="bi bi-info-circle-fill me-1"></i>Prioritas Sedang
                            </span>
                        @else
                            <span class="badge bg-info me-2 mb-2">
                                <i class="bi bi-info-circle me-1"></i>Prioritas Rendah
                            </span>
                        @endif
                        <small class="text-muted me-3 mb-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->translatedFormat('d F Y') : '-' }}
                        </small>
                        <small class="text-muted mb-2">
                            <i class="bi bi-clock me-1"></i>
                            {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('H:i') : '-' }}
                        </small>
                    </div>

                    <!-- Announcement Title -->
                    <h1 class="display-5 fw-bold mb-4" style="color: var(--primary-color);">
                        {{ $announcement->title }}
                    </h1>

                    <!-- Announcement Excerpt -->
                    @if($announcement->excerpt)
                        <div class="alert alert-info border-0 mb-4" style="background-color: var(--section-bg-color);">
                            <h6 class="mb-2" style="color: var(--primary-color);">
                                <i class="bi bi-info-circle me-2"></i>Ringkasan
                            </h6>
                            <p class="mb-0">{{ $announcement->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Announcement Content -->
                    <div class="announcement-content">
                        {!! $announcement->content !!}
                    </div>

                    <!-- Social Features -->
                    <x-social-features 
                        :item="$announcement" 
                        item-type="announcement" 
                        :likes-count="$announcement->likes_count ?? 0" 
                        :comments-count="$announcement->comments_count ?? 0" 
                    />

                    <!-- Announcement Tags -->
                    @if($announcement->tags)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-2">Tags:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $announcement->tags) as $tag)
                                    <span class="badge bg-light text-dark border">
                                        #{{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Announcements -->
            @if($relatedAnnouncements->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">
                            <i class="bi bi-collection me-2"></i>Pengumuman Lainnya
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($relatedAnnouncements as $relatedAnnouncement)
                            <div class="p-3 border-bottom">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('announcements.show', $relatedAnnouncement->slug) }}" 
                                               class="text-decoration-none" 
                                               style="color: var(--primary-color);">
                                                {{ Str::limit($relatedAnnouncement->title, 50) }}
                                            </a>
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            @if($relatedAnnouncement->priority == 'high')
                                                <span class="badge bg-danger me-2" style="font-size: 0.7rem;">Tinggi</span>
                                            @elseif($relatedAnnouncement->priority == 'medium')
                                                <span class="badge bg-warning me-2" style="font-size: 0.7rem;">Sedang</span>
                                            @else
                                                <span class="badge bg-info me-2" style="font-size: 0.7rem;">Rendah</span>
                                            @endif
                                            <small class="text-muted">
                                                {{ $relatedAnnouncement->published_at ? \Carbon\Carbon::parse($relatedAnnouncement->published_at)->translatedFormat('d M Y') : '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Contact Information -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">
                        <i class="bi bi-telephone me-2"></i>Informasi Kontak
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Butuh informasi lebih lanjut?</p>
                    <div class="mb-3">
                        <i class="bi bi-telephone me-2"></i>
                        <strong>Telepon:</strong><br>
                        <small>{{ $siteSettings->phone ?? 'Hubungi kami untuk informasi lebih lanjut' }}</small>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-envelope me-2"></i>
                        <strong>Email:</strong><br>
                        <small>{{ $siteSettings->email ?? 'info@yayasan.com' }}</small>
                    </div>
                    <a href="{{ route('contacts.index') }}" 
                       class="btn w-100" 
                       style="background-color: var(--primary-color); color: white;">
                        <i class="bi bi-envelope me-2"></i>Kirim Pesan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.announcement-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.announcement-content h1, .announcement-content h2, .announcement-content h3, 
.announcement-content h4, .announcement-content h5, .announcement-content h6 {
    color: var(--primary-color);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.announcement-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1rem 0;
}

.announcement-content blockquote {
    border-left: 4px solid var(--primary-color);
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: var(--section-bg-color);
    padding: 1rem;
    border-radius: 5px;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: var(--primary-color);
}

@endsection
