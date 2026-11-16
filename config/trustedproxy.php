<?php

/*
|--------------------------------------------------------------------------
| Trusted Proxies (Cloudflare / reverse proxy / hosting langsung)
|--------------------------------------------------------------------------
|
| Menentukan proxy mana yang dipercaya untuk header X-Forwarded-*.
| Ini penting agar aplikasi membaca IP pengunjung yang ASLI (dipakai untuk
| rate limit anti-spam, log, like) dan tahu bahwa koneksi memakai HTTPS.
|
| Atur lewat TRUSTED_PROXIES di .env, berisi daftar dipisah koma.
| Boleh campuran kata kunci dan IP/CIDR:
|
|   (kosong)            Hosting langsung, tanpa proxy apa pun.
|   cloudflare          Situs dilewatkan Cloudflare (awan oranye aktif).
|   private             Ada reverse proxy di server yang sama / jaringan lokal
|                       (Nginx/Apache proxy, Docker, Nginx Proxy Manager, dll).
|   203.0.113.10        IP reverse proxy / load balancer tertentu.
|   *                   Percaya proxy apa pun yang terhubung langsung (1 lapis).
|                       HANYA jika server tidak bisa diakses selain lewat proxy;
|                       jika tidak, IP bisa dipalsukan. Tidak cukup untuk rantai
|                       Cloudflare -> reverse proxy -> aplikasi (pakai private,cloudflare).
|
| Contoh:
|   TRUSTED_PROXIES=cloudflare
|   TRUSTED_PROXIES=private,cloudflare
|   TRUSTED_PROXIES=private,203.0.113.10
|
*/

$cloudflare = [
    // https://www.cloudflare.com/ips-v4
    '173.245.48.0/20', '103.21.244.0/22', '103.22.200.0/22', '103.31.4.0/22',
    '141.101.64.0/18', '108.162.192.0/18', '190.93.240.0/20', '188.114.96.0/20',
    '197.234.240.0/22', '198.41.128.0/17', '162.158.0.0/15', '104.16.0.0/13',
    '104.24.0.0/14', '172.64.0.0/13', '131.0.72.0/22',
    // https://www.cloudflare.com/ips-v6
    '2400:cb00::/32', '2606:4700::/32', '2803:f800::/32', '2405:b500::/32',
    '2405:8100::/32', '2a06:98c0::/29', '2c0f:f248::/32',
];

$private = [
    '127.0.0.1', '::1',
    '10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16',
    'fc00::/7',
];

$entries = array_filter(array_map('trim', explode(',', (string) env('TRUSTED_PROXIES', ''))));

$proxies = [];
foreach ($entries as $entry) {
    if ($entry === '*' || $entry === '**') {
        $proxies = $entry;
        break;
    }

    $proxies = array_merge($proxies, match (strtolower($entry)) {
        'cloudflare' => $cloudflare,
        'private', 'local' => $private,
        default => [$entry],
    });
}

return [
    'proxies' => is_array($proxies) ? array_values(array_unique($proxies)) : $proxies,
];
