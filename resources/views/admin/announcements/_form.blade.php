@php($priorities = \App\Http\Controllers\Admin\AnnouncementController::PRIORITIES)

<div class="mb-3">
    <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
           value="{{ old('title', $announcement->title) }}" required maxlength="255"
           placeholder="Contoh: Jadwal Penilaian Akhir Semester">
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="content" class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8">{{ old('content', $announcement->content) }}</textarea>
    @error('content')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
        <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
            @foreach($priorities as $value => $label)
                <option value="{{ $value }}" @selected(old('priority', $announcement->priority) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="start_date" class="form-label">Tampil mulai</label>
        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date"
               value="{{ old('start_date', optional($announcement->start_date)->format('Y-m-d')) }}">
        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="end_date" class="form-label">Tampil sampai</label>
        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date"
               value="{{ old('end_date', optional($announcement->end_date)->format('Y-m-d')) }}">
        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<p class="form-text mt-n2 mb-3">Kosongkan tanggal jika pengumuman ingin tampil terus. Lewat dari tanggal "Tampil sampai", pengumuman otomatis tidak tampil lagi di website.</p>

<div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
           @checked(old('is_active', $announcement->is_active ?? true))>
    <label class="form-check-label" for="is_active">Aktif (tampilkan di website)</label>
</div>

@include('admin.partials.simple-editor', ['selector' => '#content'])
