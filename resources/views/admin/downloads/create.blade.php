@extends('layouts.admin')

@section('title', 'Tambah File Download')
@section('page-title', 'Tambah File Download')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah File Download</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('admin.downloads._form')

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary">
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
