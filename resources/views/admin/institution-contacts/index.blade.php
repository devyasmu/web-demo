@extends('layouts.admin')

@section('title', 'CP Lembaga')
@section('page-title', 'Kelola CP Lembaga')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar CP Lembaga</h5>
                <a href="{{ route('admin.institution-contacts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah CP Lembaga
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
                    Data aktif di sini langsung muncul di footer beranda sebagai pilihan WhatsApp per lembaga.
                </div>

                @if($institutionContacts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lembaga</th>
                                    <th>CP</th>
                                    <th>WhatsApp</th>
                                    <th>Deskripsi</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($institutionContacts as $index => $contact)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <i class="{{ $contact->icon ?: 'bi bi-whatsapp' }} me-2 text-success"></i>
                                        <strong>{{ $contact->name }}</strong>
                                    </td>
                                    <td>{{ $contact->contact_person ?: '-' }}</td>
                                    <td>{{ $contact->phone ?: '-' }}</td>
                                    <td>{{ Str::limit($contact->description ?: '-', 48) }}</td>
                                    <td>{{ $contact->sort_order }}</td>
                                    <td>
                                        @if($contact->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.institution-contacts.edit', $contact) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.institution-contacts.destroy', $contact) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus CP lembaga ini?')">
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
                        <i class="bi bi-whatsapp display-1 text-muted"></i>
                        <h5 class="mt-3">Belum ada CP lembaga</h5>
                        <p class="text-muted">Tambahkan lembaga agar muncul sebagai pilihan WhatsApp di footer beranda.</p>
                        <a href="{{ route('admin.institution-contacts.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah CP Lembaga Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
