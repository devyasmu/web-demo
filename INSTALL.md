# Panduan Instalasi

Panduan memasang aplikasi ini di server sendiri: VPS dengan aaPanel atau Nginx, cPanel, dengan atau tanpa Cloudflare.

## Kebutuhan

- PHP **8.1, 8.2, atau 8.3**. PHP 8.4 ke atas belum didukung oleh versi Laravel yang dipakai.
- Ekstensi PHP: `fileinfo`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `gd`
- Fungsi PHP yang tidak boleh dinonaktifkan: `putenv`, `proc_open`, `proc_get_status`, `symlink`
- MySQL 5.7+ atau MariaDB 10.3+
- Composer 2
- Akses SSH (disarankan)

## 1. Ambil kode

Folder situs harus kosong. File bawaan panel seperti `index.html` dan `404.html` boleh dihapus, tetapi jangan hapus `.well-known/` karena dipakai untuk SSL.

```bash
cd /path/folder-situs
git init
git remote add origin https://github.com/devyasmu/web-demo.git
git fetch origin
git checkout -f -b main origin/main
```

Jika muncul `detected dubious ownership`, jalankan perintah berikut lalu ulangi perintah git yang gagal:

```bash
git config --global --add safe.directory /path/folder-situs
```

## 2. Pasang dependensi dan konfigurasi

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
nano .env
```

Isi minimal `.env` untuk server online:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.sch.id

DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database

TRUSTED_PROXIES=        # lihat bagian 4
SESSION_SECURE_COOKIE=true
```

> **Wajib:** `APP_DEBUG=false` di server online. Jika `true`, halaman error akan menampilkan konfigurasi, termasuk password database, ke pengunjung.

Lalu jalankan:

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize:clear
chmod -R 775 storage bootstrap/cache
```

Ubah pemilik folder ke user web server, misalnya `www` di aaPanel atau `www-data` di Ubuntu:

```bash
chown -R www:www /path/folder-situs
```

## 3. Arahkan web server ke folder `public`

| Panel / server | Pengaturan |
|---|---|
| **aaPanel** | Website → situs → Conf → **Site directory**: Running directory `/public`, matikan *Anti-XSS (open_basedir)*. **URL rewrite**: `laravel5`. |
| **cPanel** | Arahkan *Document Root* domain ke folder `public`. Jika tidak bisa diubah, `.htaccess` di root proyek sudah meneruskan request ke `public/`. |
| **Nginx manual** | `root /path/folder-situs/public;` dan `try_files $uri $uri/ /index.php?$query_string;` |

## 4. Cloudflare dan reverse proxy (`TRUSTED_PROXIES`)

Aplikasi membatasi spam komentar dan form kontak per IP pengunjung. Jika situs berada di belakang Cloudflare atau reverse proxy, aplikasi harus diberi tahu proxy mana yang dipercaya. Tanpa pengaturan ini, semua pengunjung terbaca dengan IP proxy yang sama, sehingga satu spammer bisa membuat pengunjung lain ikut terblokir.

| Kondisi server | Isi `TRUSTED_PROXIES` |
|---|---|
| Hosting langsung, tanpa Cloudflare atau proxy | *(kosongkan)* |
| Pakai Cloudflare (awan oranye), tanpa reverse proxy | `cloudflare` |
| Reverse proxy di server yang sama atau jaringan lokal (Nginx proxy, Docker, Nginx Proxy Manager) | `private` |
| Cloudflare **dan** reverse proxy | `private,cloudflare` |
| Reverse proxy atau load balancer di IP publik lain | IP-nya, misalnya `203.0.113.10` (bisa digabung: `203.0.113.10,cloudflare`) |

Jangan isi `*` kecuali server benar-benar tidak bisa diakses selain lewat proxy. Jika diisi `*`, penyerang bisa memalsukan IP lewat header.

### Cara memastikan pilihan yang benar

Lihat log akses web server (di aaPanel: `/www/wwwlogs/<domain>.log`). Kolom pertama adalah IP yang langsung terhubung ke aplikasi:

```bash
tail -5 /www/wwwlogs/domain-anda.sch.id.log
```

- `127.0.0.1`, `10.x`, `172.16–31.x`, atau `192.168.x`: tambahkan `private`
- IP milik Cloudflare (`172.64–71.x`, `104.16–31.x`, `162.158–159.x`, `2606:4700:...`, dan seterusnya): tambahkan `cloudflare`
- IP lain yang Anda kenali sebagai proxy: tambahkan IP tersebut

Setelah mengubah `.env`, jalankan `php artisan optimize:clear`.

### Pengaturan yang disarankan di Cloudflare

- **SSL/TLS → Overview**: mode **Full (strict)**. Hindari *Flexible*.
- **SSL/TLS → Edge Certificates**: aktifkan *Always Use HTTPS*.
- **Security → Bots**: aktifkan *Bot Fight Mode* untuk lapisan anti-spam tambahan.

### Tanpa Cloudflare

Perlindungan anti-spam ada di dalam aplikasi, jadi tetap aktif penuh tanpa Cloudflare. Untuk hosting biasa tanpa proxy, cukup kosongkan `TRUSTED_PROXIES`. Itu juga nilai bawaannya.

Yang tidak ada tanpa Cloudflare hanyalah lapisan di luar aplikasi: perlindungan DDoS, pemblokiran bot sebelum sampai ke server, dan firewall (WAF). Penggantinya bisa berupa:

- **aaPanel**: plugin firewall Nginx dari App Store.
- **cPanel**: pastikan ModSecurity atau Imunify360 dari hosting aktif.
- **VPS**: pasang `fail2ban`.
- Atau gunakan Cloudflare paket gratis.

### Kesalahan yang perlu dihindari

| Kesalahan | Akibat |
|---|---|
| Pakai Cloudflare, tetapi `TRUSTED_PROXIES` kosong | Semua pengunjung terbaca dengan IP Cloudflare yang sama, sehingga satu spammer bisa membuat pengunjung lain terblokir ("Too Many Requests"). |
| Tidak pakai Cloudflare, tetapi diisi `cloudflare` | Tidak berbahaya, tidak ada efeknya. |
| Diisi `*` padahal server bisa diakses langsung | Penyerang bisa memalsukan IP dan lolos dari pembatasan spam. |

### Header wajib di reverse proxy

Reverse proxy harus meneruskan header berikut ke aplikasi. Contoh untuk Nginx:

```nginx
proxy_set_header Host              $host;
proxy_set_header X-Forwarded-For   $proxy_add_x_forwarded_for;
proxy_set_header X-Forwarded-Proto $scheme;
proxy_set_header X-Forwarded-Port  $server_port;
```

## 5. SSL / HTTPS

Aktifkan SSL untuk domain, misalnya Let's Encrypt di aaPanel atau cPanel. Aplikasi otomatis memakai `https` untuk semua link (`FORCE_HTTPS`, aktif bawaan di production). Hanya jika domain **belum** punya SSL, tambahkan `FORCE_HTTPS=false` dan `SESSION_SECURE_COOKIE=false` di `.env`.

## 6. Setelah instalasi

1. Masuk admin di `https://domain-anda/masuk-admin`. Halaman `/admin` sengaja tampil 404 sebelum login.
2. **Segera ganti password admin bawaan** (`admin@webdemo.test` / `password`) dan email admin.
3. Ubah identitas situs di menu **Site Settings**.

## Data contoh (dummy)

Instalasi baru (`php artisan db:seed --force` di langkah 2) sudah otomatis terisi data contoh: slider, berita, program, galeri, pengumuman, file download (PDF), testimoni, FAQ, statistik, dan satu halaman contoh di `/contoh-profil-sekolah`. Semua dilengkapi gambar ilustrasi, dan setiap artikel diberi catatan bahwa isinya hanya contoh. Data ini membantu admin melihat bentuk setiap menu sebelum mengisi data asli.

Gambar dan PDF-nya disimpan di repo (`database/seeders/demo-assets/`), lalu disalin ke `storage/app/public/demo/` saat seeder dijalankan.

**Menambahkan data contoh ke situs yang sudah berjalan:**

```bash
php artisan db:seed --class=DemoContentSeeder --force
chown -R www:www storage    # sesuaikan user web server
```

- Aman dijalankan berulang kali. Data tidak akan dobel.
- Tidak mengubah akun admin maupun Site Settings.
- Data lama yang gambarnya hilang akan diberi gambar contoh.

> **Jangan** menjalankan `php artisan db:seed --force` tanpa `--class` di situs yang sudah berjalan. Perintah itu juga menjalankan `UserSeeder`, yang mengembalikan password admin ke `password`.

**Menghapus semua data contoh** setelah data asli siap:

```bash
php artisan db:seed --class=DemoContentCleanupSeeder --force
```

Perintah ini menghapus data contoh beserta komentar, like, gambar, dan PDF-nya. Data yang gambarnya sudah diganti admin tidak ikut terhapus. Kategori dan menu juga tetap ada.

## Perlindungan spam yang sudah aktif

- Komentar: maksimal 3 per menit dan 20 per hari per IP, dan wajib disetujui admin sebelum tampil.
- Form kontak: maksimal 2 per menit dan 10 per hari per IP.
- Kolom jebakan bot (honeypot) dan token waktu: form yang dikirim terlalu cepat atau tanpa token akan ditolak.
- Kiriman ditolak jika berisi lebih dari satu tautan, kata spam umum (judi/slot, dan sejenisnya), atau komentar yang sama dari IP yang sama.

Kiriman yang diblokir dicatat di `storage/logs/laravel.log` dengan pesan `Comment blocked` atau `Contact form blocked`.

## Pembaruan

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
```

## Masalah umum

| Gejala | Penyebab / solusi |
|---|---|
| Error 500 | Lihat `tail -50 storage/logs/laravel.log`. Periksa permission `storage` dan `bootstrap/cache`. |
| `Class "finfo" not found` | Aktifkan ekstensi PHP `fileinfo`. |
| `composer install` gagal soal versi PHP | Pastikan PHP di terminal (`php -v`) dan PHP situs 8.1–8.3. |
| Tampilan tanpa CSS atau link ke `http://` | Periksa `APP_URL` dan SSL. Di belakang proxy, periksa `TRUSTED_PROXIES` dan header `X-Forwarded-Proto`. |
| Gambar atau logo tidak muncul | Jalankan `php artisan storage:link`. |
| Pengunjung kena "Too Many Requests" padahal tidak spam | `TRUSTED_PROXIES` belum diatur, sehingga semua pengunjung terbaca dengan IP proxy yang sama. |
