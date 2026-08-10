@extends('layouts.admin')

@section('title', 'Tambah CP Lembaga')
@section('page-title', 'Tambah CP Lembaga')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah CP Lembaga</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.institution-contacts.store') }}" method="POST">
                    @csrf
                    @include('admin.institution-contacts.partials.form', ['institutionContact' => null])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
