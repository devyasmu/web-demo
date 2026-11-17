@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="alert alert-primary d-flex flex-wrap align-items-center gap-2 mb-4">
    <i class="bi bi-journal-text fs-4"></i>
    <div class="me-auto">
        <strong>Baru mengelola website ini?</strong>
        Baca panduan cara mengisi setiap menu, ukuran gambar yang disarankan, dan solusi masalah umum.
    </div>
    <a href="{{ route('admin.guide') }}" class="btn btn-primary btn-sm">Buka Panduan</a>
</div>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Post
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['posts'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Post Terbit
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['published_posts'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Kategori
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['categories'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Kontak Baru
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['unread_contacts'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-envelope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Posts -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Post Terbaru</h6>
                <a href="{{ route('admin.admin-posts.index') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Tambah Post
                </a>
            </div>
            <div class="card-body">
                @if($recent_posts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_posts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.admin-posts.edit', $post->id) }}" class="text-decoration-none">
                                            {{ Str::limit($post->title, 40) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $post->category->color }}">
                                            {{ $post->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($post->is_published)
                                            <span class="badge bg-success">Terbit</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada post. <a href="{{ route('admin.admin-posts.create') }}">Buat post pertama</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Kontak Terbaru</h6>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-eye"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($recent_contacts->count() > 0)
                    @foreach($recent_contacts as $contact)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-person text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">{{ $contact->name }}</div>
                            <div class="text-muted small">{{ $contact->subject }}</div>
                            <div class="text-muted small">{{ $contact->created_at->diffForHumans() }}</div>
                        </div>
                        @if(!$contact->is_read)
                            <span class="badge bg-danger">Baru</span>
                        @endif
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-envelope fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada pesan kontak</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.admin-posts.create') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle"></i><br>
                            <small>Tambah Post</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.admin-programs.create') }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-book"></i><br>
                            <small>Tambah Program</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.galleries.create') }}" class="btn btn-outline-info w-100">
                            <i class="bi bi-images"></i><br>
                            <small>Tambah Galeri</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.site-settings.index') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-gear"></i><br>
                            <small>Pengaturan</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-xs {
    font-size: 0.7rem;
}
.font-weight-bold {
    font-weight: 700 !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
</style>
@endpush
