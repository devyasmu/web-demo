@extends('layouts.public')

@section('title', 'Tentang Kami')
@section('description', 'Tentang Yayasan Ma\'arif NU Hidyatus Salam - Membangun Generasi Berkarakter dan Berprestasi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">Tentang Kami</h1>
                <p class="lead text-muted">Yayasan Ma'arif NU Hidyatus Salam</p>
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if(isset($siteSettings) && $siteSettings->logo)
                                <img src="{{ asset('storage/' . $siteSettings->logo) }}" alt="Logo Yayasan" class="img-fluid" style="max-height: 200px;">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h2 class="h3 mb-3">{{ $siteSettings->site_name ?? 'Yayasan Mu\'allimin Mu\'allimat' }}</h2>
                            <p class="lead">{{ $siteSettings->site_tagline ?? 'Membangun Generasi Berkarakter dan Berprestasi' }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h3 class="h4 mb-3">Sejarah Singkat</h3>
                        <p class="text-justify">
                            {{ $siteSettings->site_description ?? 'Yayasan Mu\'allimin Mu\'allimat didirikan dengan komitmen untuk memberikan pendidikan berkualitas dengan nilai-nilai Islam yang kuat. Kami berdedikasi untuk membangun generasi yang berkarakter, berprestasi, dan memiliki akhlak mulia.' }}
                        </p>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <h3 class="h4 mb-3">Visi</h3>
                            <p class="text-justify">
                                Menjadi lembaga pendidikan Islam terdepan yang menghasilkan generasi berkarakter, berprestasi, dan berakhlak mulia.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="h4 mb-3">Misi</h3>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle text-primary me-2"></i>Menyelenggarakan pendidikan berkualitas</li>
                                <li><i class="bi bi-check-circle text-primary me-2"></i>Mengembangkan karakter Islami</li>
                                <li><i class="bi bi-check-circle text-primary me-2"></i>Membina akhlak mulia</li>
                                <li><i class="bi bi-check-circle text-primary me-2"></i>Menyiapkan generasi unggul</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="h4 mb-3">Kontak Kami</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="bi bi-geo-alt text-primary me-2"></i> {{ $siteSettings->address ?? 'Jl. Pendidikan No. 123, Jakarta Selatan 12345' }}</p>
                                <p><i class="bi bi-telephone text-primary me-2"></i> {{ $siteSettings->phone ?? '+62 21 1234 5678' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-envelope text-primary me-2"></i> {{ $siteSettings->email ?? 'info@yayasanpendidikan.com' }}</p>
                                <p><i class="bi bi-globe text-primary me-2"></i> {{ $siteSettings->site_name ?? 'yasmumanyar.or.id' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
