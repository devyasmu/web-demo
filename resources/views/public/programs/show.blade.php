@extends('layouts.public')

@section('title', $program->title . ' - Program - ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color: var(--primary-color);">Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('programs.index') }}" style="color: var(--primary-color);">Program</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $program->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                @if($program->featured_image)
                    <img src="{{ Storage::url($program->featured_image) }}" 
                         alt="{{ $program->title }}" 
                         class="card-img-top" style="height: 400px; object-fit: cover;">
                @endif

                <div class="card-body p-4">
                    <!-- Program Meta -->
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <span class="badge bg-primary me-2 mb-2">{{ $program->category }}</span>
                        @if($program->featured)
                            <span class="badge bg-warning me-2 mb-2">
                                <i class="bi bi-star-fill me-1"></i>Program Unggulan
                            </span>
                        @endif
                    </div>

                    <!-- Program Title -->
                    <h1 class="display-5 fw-bold mb-4" style="color: var(--primary-color);">
                        {{ $program->title }}
                    </h1>

                    <!-- Program Description -->
                    @if($program->description)
                        <div class="mb-4">
                            <h5 style="color: var(--primary-color);">Deskripsi Program</h5>
                            <p class="lead">{{ $program->description }}</p>
                        </div>
                    @endif

                    <!-- Program Content -->
                    @if($program->content)
                        <div class="program-content">
                            {!! $program->content !!}
                        </div>
                    @endif

                    <!-- Program Features -->
                    @if($program->features)
                        <div class="mt-4">
                            <h5 style="color: var(--primary-color);">Fitur Program</h5>
                            <ul class="list-unstyled">
                                @foreach(explode("\n", $program->features) as $feature)
                                    @if(trim($feature))
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            {{ trim($feature) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Program Requirements -->
                    @if($program->requirements)
                        <div class="mt-4">
                            <h5 style="color: var(--primary-color);">Persyaratan</h5>
                            <ul class="list-unstyled">
                                @foreach(explode("\n", $program->requirements) as $requirement)
                                    @if(trim($requirement))
                                        <li class="mb-2">
                                            <i class="bi bi-arrow-right-circle text-primary me-2"></i>
                                            {{ trim($requirement) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Contact Information -->
                    <div class="mt-4 p-3 rounded" style="background-color: var(--section-bg-color);">
                        <h5 style="color: var(--primary-color);">Informasi Pendaftaran</h5>
                        <p class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            <strong>Telepon:</strong> {{ $siteSettings->phone ?? 'Hubungi kami untuk informasi lebih lanjut' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            <strong>Email:</strong> {{ $siteSettings->email ?? 'info@yayasan.com' }}
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt me-2"></i>
                            <strong>Alamat:</strong> {{ $siteSettings->address ?? 'Alamat yayasan' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Programs -->
            @if($relatedPrograms->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">
                            <i class="bi bi-collection me-2"></i>Program Lainnya
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($relatedPrograms as $relatedProgram)
                            <div class="p-3 border-bottom">
                                <div class="d-flex">
                                    @if($relatedProgram->featured_image)
                                        <img src="{{ Storage::url($relatedProgram->featured_image) }}" 
                                             alt="{{ $relatedProgram->title }}" 
                                             class="rounded me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('programs.show', $relatedProgram->slug) }}" 
                                               class="text-decoration-none" 
                                               style="color: var(--primary-color);">
                                                {{ Str::limit($relatedProgram->title, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            {{ $relatedProgram->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Contact Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">
                        <i class="bi bi-telephone me-2"></i>Hubungi Kami
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Ingin tahu lebih lanjut tentang program ini?</p>
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
.program-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.program-content h1, .program-content h2, .program-content h3, 
.program-content h4, .program-content h5, .program-content h6 {
    color: var(--primary-color);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.program-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1rem 0;
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
@endsection
