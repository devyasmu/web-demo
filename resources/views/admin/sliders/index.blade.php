@extends('layouts.admin')

@section('title', 'Manajemen Slider')
@section('page-title', 'Manajemen Slider')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Daftar Slider</h5>
                    <small class="text-muted">Maksimal {{ $maxSliders }} slider. Saat ini {{ $sliders->count() }} slider.</small>
                </div>
                @if($sliders->count() < $maxSliders)
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Tambah Slider
                    </a>
                @else
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="bi bi-plus"></i> Batas Terpenuhi
                    </button>
                @endif
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                @endif

                @if($sliders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                <tr>
                                    <td>
                                        @if($slider->image)
                                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" 
                                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ Str::limit($slider->description, 50) }}</td>
                                    <td>{{ $slider->order }}</td>
                                    <td>
                                        @if($slider->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
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
                    <div class="text-center py-5">
                        <i class="bi bi-images fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada slider</h5>
                        <p class="text-muted">Mulai dengan menambahkan slider pertama Anda.</p>
                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tambah Slider
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
