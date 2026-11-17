@extends('layouts.admin')

@section('title', 'Edit FAQ')
@section('page-title', 'Edit FAQ')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit FAQ</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('admin.faqs._form')

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
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
