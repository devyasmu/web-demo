<?php

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

/**
 * Penyaring spam ringan untuk form publik (komentar & kontak).
 *
 * Lapisan yang dipakai:
 *  - Honeypot: field tersembunyi "website" yang hanya diisi bot.
 *  - Waktu isi form: token terenkripsi berisi waktu form ditampilkan;
 *    kiriman yang terlalu cepat (bot) atau token kedaluwarsa/palsu ditolak.
 *  - Batas jumlah tautan dan kata-kata spam umum.
 */
class SpamGuard
{
    public const HONEYPOT_FIELD = 'website';
    public const TIMESTAMP_FIELD = '_form_token';

    /** Minimal detik antara form tampil dan dikirim. */
    private const MIN_SECONDS = 3;

    /** Token form berlaku maksimal (detik). */
    private const MAX_SECONDS = 60 * 60 * 6;

    private const MAX_LINKS = 1;

    private const BLOCKED_WORDS = [
        'casino', 'slot gacor', 'slot online', 'judi', 'togel', 'poker online',
        'viagra', 'cialis', 'porn', 'bokep', 'crypto airdrop', 'pinjol',
        'situs gacor', 'maxwin', 'rtp live',
    ];

    /** Token waktu untuk ditaruh di hidden input form. */
    public static function token(): string
    {
        return Crypt::encryptString((string) time());
    }

    /**
     * Kembalikan alasan penolakan, atau null jika kiriman lolos.
     *
     * @param  string[]  $textFields  field yang dicek isinya (tautan & kata spam)
     */
    public static function check(Request $request, array $textFields): ?string
    {
        if (filled($request->input(self::HONEYPOT_FIELD))) {
            return 'honeypot';
        }

        $token = $request->input(self::TIMESTAMP_FIELD);
        if (!is_string($token) || $token === '') {
            return 'missing_token';
        }

        try {
            $renderedAt = (int) Crypt::decryptString($token);
        } catch (DecryptException) {
            return 'invalid_token';
        }

        $elapsed = time() - $renderedAt;
        if ($elapsed < self::MIN_SECONDS) {
            return 'too_fast';
        }
        if ($elapsed > self::MAX_SECONDS) {
            return 'expired_token';
        }

        $text = mb_strtolower(implode(' ', array_map(
            fn ($field) => (string) $request->input($field, ''),
            $textFields
        )));

        $links = preg_match_all('~(https?://|www\.|\[url|<a\s)~i', $text);
        if ($links > self::MAX_LINKS) {
            return 'too_many_links';
        }

        foreach (self::BLOCKED_WORDS as $word) {
            if (str_contains($text, $word)) {
                return 'blocked_word';
            }
        }

        return null;
    }
}
