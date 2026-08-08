@extends('layouts.admin')

@section('title', 'Manajemen Post')
@section('page-title', 'Manajemen Post')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Post</h5>
                <a href="{{ route('admin.admin-posts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah Post
                </a>
            </div>
            <div class="card-body">
                @if($posts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" 
                                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $post->category->color }}">
                                            {{ $post->category->name }}
                                        </span>
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        @if($post->is_published)
                                            <span class="badge bg-success">Terbit</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                        @if($post->is_featured)
                                            <span class="badge bg-primary">Featured</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.admin-posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.admin-posts.destroy', $post) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus post ini?')">
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
                        <i class="bi bi-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada post</h5>
                        <p class="text-muted">Mulai dengan menambahkan post pertama Anda.</p>
                        <a href="{{ route('admin.admin-posts.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tambah Post
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
