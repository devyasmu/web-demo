@extends('layouts.public')

@section('title', 'Kontak - ' . $siteSettings->site_name)
@section('description', 'Hubungi ' . $siteSettings->site_name . ' untuk informasi lebih lanjut')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-telephone me-3"></i>Hubungi Kami
                </h1>
                <p class="lead text-muted">Kami siap membantu dan menjawab pertanyaan Anda</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h4 class="mb-0">
                        <i class="bi bi-envelope me-2"></i>Kirim Pesan
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contacts.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="bi bi-person me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">
                                        <i class="bi bi-telephone me-1"></i>Nomor Telepon
                                    </label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">
                                        <i class="bi bi-tag me-1"></i>Subjek <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">
                                <i class="bi bi-chat-text me-1"></i>Pesan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" 
                                    style="background-color: var(--primary-color); color: white;">
                                <i class="bi bi-send me-2"></i>Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-4">
            <!-- Contact Details -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Informasi Kontak
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill me-3 mt-1" style="color: var(--primary-color); font-size: 1.2rem;"></i>
                            <div>
                                <h6 class="mb-1">Alamat</h6>
                                <p class="text-muted mb-0">{{ $siteSettings->address ?? 'Alamat yayasan belum diatur' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-telephone-fill me-3 mt-1" style="color: var(--primary-color); font-size: 1.2rem;"></i>
                            <div>
                                <h6 class="mb-1">Telepon</h6>
                                <p class="text-muted mb-0">
                                    <a href="tel:{{ $siteSettings->phone ?? '' }}" 
                                       class="text-decoration-none" 
                                       style="color: var(--primary-color);">
                                        {{ $siteSettings->phone ?? 'Nomor telepon belum diatur' }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-envelope-fill me-3 mt-1" style="color: var(--primary-color); font-size: 1.2rem;"></i>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <p class="text-muted mb-0">
                                    <a href="mailto:{{ $siteSettings->email ?? '' }}" 
                                       class="text-decoration-none" 
                                       style="color: var(--primary-color);">
                                        {{ $siteSettings->email ?? 'Email belum diatur' }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($siteSettings->website)
                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-globe me-3 mt-1" style="color: var(--primary-color); font-size: 1.2rem;"></i>
                                <div>
                                    <h6 class="mb-1">Website</h6>
                                    <p class="text-muted mb-0">
                                        <a href="{{ $siteSettings->website }}" 
                                           class="text-decoration-none" 
                                           style="color: var(--primary-color);" 
                                           target="_blank">
                                            {{ $siteSettings->website }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Office Hours -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">
                        <i class="bi bi-clock me-2"></i>Jam Operasional
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Senin - Jumat:</strong><br>
                        <span class="text-muted">08:00 - 17:00</span>
                    </div>
                    <div class="mb-2">
                        <strong>Sabtu:</strong><br>
                        <span class="text-muted">08:00 - 12:00</span>
                    </div>
                    <div>
                        <strong>Minggu:</strong><br>
                        <span class="text-muted">Tutup</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section (Optional) -->
    @if($siteSettings->google_maps_embed)
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">
                            <i class="bi bi-map me-2"></i>Lokasi Kami
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="ratio ratio-16x9">
                            {!! $siteSettings->google_maps_embed !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.25);
}

.btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.25);
}

.alert {
    border-radius: 10px;
}

.card {
    border-radius: 15px;
}

.ratio {
    border-radius: 0 0 15px 15px;
    overflow: hidden;
}
</style>
@endsection
