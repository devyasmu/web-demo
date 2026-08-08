@extends('layouts.admin')

@section('title', 'Edit Komentar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-pencil me-2"></i>Edit Komentar
                    </h3>
                </div>

                <form method="POST" action="{{ route('admin.comments.update', $comment) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- Comment Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Informasi Komentar</h6>
                                <div class="bg-light p-3 rounded">
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Item:</strong><br>
                                            <span class="text-muted">{{ class_basename($comment->commentable_type) }}</span>
                                        </div>
                                        <div class="col-6">
                                            <strong>Tanggal:</strong><br>
                                            <span class="text-muted">{{ $comment->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <strong>IP Address:</strong><br>
                                            <span class="text-muted">{{ $comment->user_ip ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-6">
                                            <strong>Status:</strong><br>
                                            @if($comment->is_approved)
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Item yang Dikomentari</h6>
                                <div class="bg-light p-3 rounded">
                                    <strong>{{ $comment->commentable->title ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ Str::limit($comment->commentable->content ?? $comment->commentable->excerpt ?? 'N/A', 100) }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $comment->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $comment->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Komentar *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="5" 
                                      required>{{ old('content', $comment->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_approved" 
                                       name="is_approved" 
                                       value="1" 
                                       {{ old('is_approved', $comment->is_approved) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_approved">
                                    <strong>Setujui komentar ini</strong>
                                    <small class="d-block text-muted">Komentar yang disetujui akan tampil di halaman publik</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
