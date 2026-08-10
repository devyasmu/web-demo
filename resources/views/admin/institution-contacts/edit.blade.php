@extends('layouts.admin')

@section('title', 'Edit CP Lembaga')
@section('page-title', 'Edit CP Lembaga')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit CP Lembaga</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.institution-contacts.update', $institutionContact) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.institution-contacts.partials.form', ['institutionContact' => $institutionContact])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
