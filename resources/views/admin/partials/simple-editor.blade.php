{{-- Editor teks sederhana (tebal, miring, daftar, tautan). Pakai: @include('admin.partials.simple-editor', ['selector' => '#content']) --}}
@push('scripts')
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: @json($selector),
        height: {{ $height ?? 320 }},
        menubar: false,
        plugins: ['lists', 'link', 'autolink', 'table', 'wordcount'],
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link table | removeformat',
        block_formats: 'Paragraf=p; Subjudul=h3; Subjudul kecil=h4',
        branding: false,
        promotion: false,
        setup: function (editor) {
            // Isi textarea asli sebelum form dikirim, agar validasi "wajib diisi" bekerja.
            editor.on('change input', function () { editor.save(); });
        }
    });
});
</script>
@endpush
