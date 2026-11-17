<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Link untuk tombol/teks: boleh alamat di website sendiri ("/berita")
 * atau alamat lengkap ("https://..."). Skema lain (javascript:, data:) ditolak.
 */
class SiteLink implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = trim((string) $value);

        $isInternal = str_starts_with($value, '/') && !str_starts_with($value, '//');
        $isExternal = preg_match('#^https?://[^\s/$.?\#].[^\s]*$#i', $value) === 1;

        if (!$isInternal && !$isExternal) {
            $fail('Link harus diawali "/" (halaman di website ini, misalnya /berita) atau "https://" (alamat lengkap).');
        }
    }
}
