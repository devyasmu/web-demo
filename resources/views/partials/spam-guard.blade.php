{{-- Anti-spam: honeypot (harus kosong) + token waktu form. Lihat App\Support\SpamGuard. --}}
<div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
    <label for="{{ \App\Support\SpamGuard::HONEYPOT_FIELD }}_{{ $formId ?? 'form' }}">Jangan isi kolom ini</label>
    <input type="text" id="{{ \App\Support\SpamGuard::HONEYPOT_FIELD }}_{{ $formId ?? 'form' }}"
           name="{{ \App\Support\SpamGuard::HONEYPOT_FIELD }}" value="" tabindex="-1" autocomplete="off">
</div>
<input type="hidden" name="{{ \App\Support\SpamGuard::TIMESTAMP_FIELD }}" value="{{ \App\Support\SpamGuard::token() }}">
