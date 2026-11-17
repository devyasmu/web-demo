@php($allowed = str_replace(',', ', ', \App\Http\Controllers\Admin\DownloadController::ALLOWED_TYPES))
@php($maxMb = \App\Http\Controllers\Admin\DownloadController::MAX_SIZE_KB / 1024)

<div class="mb-3">
    <label for="title" class="form-label">Judul File <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
           value="{{ old('title', $download->title) }}" required maxlength="255"
           placeholder="Contoh: Kalender Akademik 2026/2027">
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Keterangan</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3"
              placeholder="Penjelasan singkat isi file">{{ old('description', $download->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="file" class="form-label">File @unless($download->exists)<span class="text-danger">*</span>@endunless</label>
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file"
               accept=".{{ str_replace(', ', ',.', $allowed) }}" @unless($download->exists) required @endunless>
        <div class="form-text">Jenis: {{ $allowed }}. Maksimal {{ $maxMb }} MB.</div>
        @if($download->exists)
            <div class="form-text">
                File saat ini: <strong>{{ $download->file_name }}</strong>
                ({{ number_format($download->file_size / 1024, 0, ',', '.') }} KB).
                Kosongkan jika tidak ingin mengganti file.
            </div>
        @endif
        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
            <option value="">— Tanpa kategori —</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $download->category_id) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
           @checked(old('is_active', $download->is_active ?? true))>
    <label class="form-check-label" for="is_active">Aktif (tampilkan di website)</label>
</div>
