@extends('layouts.public')

@section('title', 'Visi dan Misi')
@section('description', 'Visi dan Misi Yayasan Mu\'allimin Mu\'allimat - Membangun Generasi Berkarakter dan Berprestasi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">Visi dan Misi</h1>
                <p class="lead text-muted">Yayasan Mu'allimin Mu'allimat</p>
            </div>

            <div class="row">
                <!-- Visi -->
                <div class="col-lg-6 mb-5">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <i class="bi bi-eye display-1 text-primary"></i>
                            </div>
                            <h2 class="h3 mb-4 text-primary">Visi</h2>
                            <p class="lead fw-bold">
                                Menjadi lembaga pendidikan Islam terdepan yang menghasilkan generasi berkarakter, berprestasi, dan berakhlak mulia.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Misi -->
                <div class="col-lg-6 mb-5">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-body p-5">
                            <div class="mb-4 text-center">
                                <i class="bi bi-target display-1 text-success"></i>
                            </div>
                            <h2 class="h3 mb-4 text-center text-success">Misi</h2>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Menyelenggarakan pendidikan berkualitas</strong><br>
                                    <small class="text-muted">Dengan kurikulum yang terintegrasi antara ilmu pengetahuan dan nilai-nilai Islam</small>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Mengembangkan karakter Islami</strong><br>
                                    <small class="text-muted">Membentuk pribadi yang berakhlak mulia dan beriman</small>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Membina akhlak mulia</strong><br>
                                    <small class="text-muted">Menanamkan nilai-nilai kebaikan dan kejujuran</small>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Menyiapkan generasi unggul</strong><br>
                                    <small class="text-muted">Yang siap menghadapi tantangan masa depan</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai-nilai -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <h2 class="h3 text-center mb-5 text-primary">Nilai-nilai Kami</h2>
                            <div class="row">
                                <div class="col-md-3 text-center mb-4">
                                    <div class="p-4">
                                        <i class="bi bi-heart-fill display-4 text-danger mb-3"></i>
                                        <h4 class="h5">Kasih Sayang</h4>
                                        <p class="small text-muted">Mengasihi sesama dengan tulus</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-4">
                                    <div class="p-4">
                                        <i class="bi bi-shield-check display-4 text-success mb-3"></i>
                                        <h4 class="h5">Kejujuran</h4>
                                        <p class="small text-muted">Berbicara dan bertindak dengan benar</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-4">
                                    <div class="p-4">
                                        <i class="bi bi-people-fill display-4 text-info mb-3"></i>
                                        <h4 class="h5">Kerjasama</h4>
                                        <p class="small text-muted">Bekerja sama untuk kebaikan bersama</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-4">
                                    <div class="p-4">
                                        <i class="bi bi-star-fill display-4 text-warning mb-3"></i>
                                        <h4 class="h5">Keunggulan</h4>
                                        <p class="small text-muted">Berusaha menjadi yang terbaik</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Komitmen -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card shadow-lg border-0 bg-primary text-white">
                        <div class="card-body p-5 text-center">
                            <h2 class="h3 mb-4">Komitmen Kami</h2>
                            <p class="lead mb-4">
                                Kami berkomitmen untuk memberikan pendidikan terbaik yang mengintegrasikan ilmu pengetahuan modern dengan nilai-nilai Islam yang mulia, sehingga menghasilkan generasi yang tidak hanya cerdas secara intelektual, tetapi juga memiliki karakter yang kuat dan akhlak yang mulia.
                            </p>
                            <a href="{{ route('contacts.index') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-telephone me-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
