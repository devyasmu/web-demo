@extends('layouts.admin')

@section('title', 'Akses Cepat')
@section('page-title', 'Kelola Akses Cepat')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Akses Cepat</h5>
                <a href="{{ route('admin.quick-links.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Akses Cepat
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Akses cepat ditampilkan di halaman utama (di bawah hero section, di atas Keunggulan Kami). Link akan terbuka di tab baru.
                </div>

                @if($quickLinks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Icon</th>
                                    <th>Nama</th>
                                    <th>URL</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quickLinks as $index => $link)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($link->image)
                                            <img src="{{ asset('storage/' . $link->image) }}" alt="{{ $link->title }}" class="rounded" style="max-width: 36px; max-height: 36px; object-fit: contain;">
                                        @else
                                            <i class="{{ $link->icon }}" style="font-size: 1.5rem;"></i>
                                        @endif
                                    </td>
                                    <td>{{ $link->title }}</td>
                                    <td>
                                        <a href="{{ $link->url }}" target="_blank" rel="noopener" class="text-truncate d-inline-block" style="max-width: 200px;">
                                            {{ Str::limit($link->url, 40) }}
                                        </a>
                                    </td>
                                    <td>{{ $link->order }}</td>
                                    <td>
                                        @if($link->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.quick-links.edit', $link) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.quick-links.destroy', $link) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus akses cepat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-link-45deg display-1 text-muted"></i>
                        <h5 class="mt-3">Belum ada akses cepat</h5>
                        <p class="text-muted">Tambahkan ikon navigasi yang ditampilkan di bawah hero section.</p>
                        <a href="{{ route('admin.quick-links.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Akses Cepat Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
