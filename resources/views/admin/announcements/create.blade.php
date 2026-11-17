@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')
@section('page-title', 'Tambah Pengumuman')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Pengumuman</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.announcements.store') }}" method="POST">
                    @csrf

                    @include('admin.announcements._form')

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
