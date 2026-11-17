<div class="mb-3">
    <label for="question" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question"
           value="{{ old('question', $faq->question) }}" required maxlength="255"
           placeholder="Contoh: Kapan pendaftaran siswa baru dibuka?">
    @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="answer" class="form-label">Jawaban <span class="text-danger">*</span></label>
    <textarea class="form-control @error('answer') is-invalid @enderror" id="answer" name="answer" rows="6">{{ old('answer', $faq->answer) }}</textarea>
    @error('answer')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="order" class="form-label">Urutan</label>
        <input type="number" min="0" class="form-control @error('order') is-invalid @enderror" id="order" name="order"
               value="{{ old('order', $faq->order ?? 0) }}">
        <div class="form-text">Angka kecil tampil lebih dulu.</div>
        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
           @checked(old('is_active', $faq->is_active ?? true))>
    <label class="form-check-label" for="is_active">Aktif (tampilkan di website)</label>
</div>

@include('admin.partials.simple-editor', ['selector' => '#answer', 'height' => 260])
