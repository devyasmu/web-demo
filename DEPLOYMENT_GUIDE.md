# Panduan Deployment Web Yayasan

## Masalah yang Diperbaiki

1. **Error Database Connection**: Aplikasi mengalami error karena tidak bisa terhubung ke database MySQL
2. **Error Handling**: Ditambahkan error handling di HomeController untuk menangani masalah koneksi database
3. **View Protection**: Diperbaiki view home.blade.php agar bisa handle data null dengan aman

## File yang Diperbaiki

### 1. HomeController.php
- Ditambahkan try-catch block untuk menangani error database
- Fallback data jika database tidak bisa diakses
- Error logging untuk debugging

### 2. home.blade.php
- Ditambahkan pengecekan null untuk semua data dari database
- Alert error jika ada masalah koneksi database
- Safe navigation untuk semua collection dan pagination

### 3. .env.example
- Dibuat file .env.example dengan konfigurasi database yang benar
- Template untuk konfigurasi server production

## Instruksi Deployment

### 1. Upload File ke Server
```bash
# Upload semua file ke server melalui AA Panel File Manager
# Pastikan semua file ter-upload dengan benar
```

### 2. Konfigurasi .env
```bash
# Copy .env.example ke .env
cp .env.example .env

# Edit .env dengan konfigurasi database server Anda
nano .env
```

### 3. Konfigurasi Database di .env
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migration
```bash
php artisan migrate
```

### 6. Seed Data (Opsional)
```bash
php artisan db:seed
```

### 7. Set Permission
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 8. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Troubleshooting

### Jika Masih Ada Error Database
1. Pastikan database sudah dibuat di server
2. Pastikan username dan password database benar
3. Pastikan user database memiliki permission yang cukup
4. Cek log error di `storage/logs/laravel.log`

### Jika Aplikasi Tidak Bisa Diakses
1. Pastikan web server (Apache/Nginx) sudah dikonfigurasi dengan benar
2. Di cPanel: gunakan .htaccess root agar tidak perlu mengubah document root (lihat bagian cPanel di bawah)
3. Cek permission file dan folder
4. Pastikan PHP version minimal 8.0

### Error 500: Class "finfo" not found
Error ini muncul jika ekstensi PHP **fileinfo** tidak aktif (umum di shared hosting/cPanel).

**Solusi di cPanel:**
1. Masuk ke **cPanel** → **Select PHP Version** atau **MultiPHP INI Editor**
2. Pilih domain/versi PHP yang dipakai
3. Centang / aktifkan ekstensi **fileinfo**
4. Simpan

Tanpa fileinfo, halaman yang memakai upload/Storage (mis. Site Settings) bisa 500. Aplikasi sudah memakai fallback di AssetHelper agar halaman Site Settings tetap bisa dibuka; untuk **upload logo/favicon** tetap disarankan mengaktifkan fileinfo.

### Logo/Gambar Tidak Bisa Dimuat: "Logo tidak dapat dimuat"

Error ini muncul jika **symlink storage** belum dibuat atau tidak valid.

**Solusi:**

1. **Buat symlink storage** (wajib setelah deploy):
   ```bash
   cd /path/ke/public_html   # atau path root Laravel Anda
   php artisan storage:link
   ```

2. **Verifikasi symlink ada:**
   ```bash
   ls -la public/storage
   ```
   Harus menunjukkan link ke `../storage/app/public`

3. **Jika symlink tidak bisa dibuat** (beberapa hosting tidak allow symlink):
   - Alternatif: Copy isi `storage/app/public` ke `public/storage` secara manual
   - Atau gunakan File Manager di cPanel untuk membuat symlink manual

4. **Set permission yang benar:**
   ```bash
   chmod -R 755 storage
   chmod -R 755 public/storage
   ```

**Catatan:** Setelah upload logo/favicon baru, pastikan symlink `public/storage` → `storage/app/public` ada agar gambar bisa diakses via browser.

---

## Deployment di cPanel (Tanpa Mengubah Document Root)

Di cPanel, document root biasanya `public_html`. Agar Laravel jalan **tanpa** mengatur document root ke folder `public`, gunakan .htaccess di root.

### Struktur folder di cPanel

Upload seluruh isi proyek Laravel ke `public_html` sehingga strukturnya:

```
public_html/                    ← document root (tetap)
├── .htaccess                   ← file ini mengarahkan semua request ke public/
├── app/
├── bootstrap/
├── config/
├── public/
│   ├── .htaccess
│   ├── index.php
│   ├── favicon.ico
│   └── ...
├── resources/
├── routes/
├── storage/
├── vendor/
└── ...
```

### Cara pakai

1. **Upload semua file** ke `public_html` (termasuk file `.htaccess` yang ada di root proyek).
2. **Jangan ubah document root** di cPanel — biarkan mengarah ke `public_html`.
3. File **`.htaccess` di root** (satu tingkat di atas folder `public`) akan:
   - Mengarahkan semua request ke `public/` secara internal
   - Melayani file statis (CSS, JS, gambar) dari `public/` jika ada
   - Menyerahkan route lain ke `public/index.php` (Laravel)

### Isi .htaccess root (sudah disertakan di proyek)

File `.htaccess` di root proyek (satu folder dengan `app/`, `public/`, dll.) berisi:

- Rewrite ke `public/` untuk file yang benar-benar ada di `public/`
- Rewrite ke `public/index.php` untuk semua URL lain (home, admin, API, dll.)

Dengan ini, URL di browser tetap normal (mis. `https://domainanda.com/`, `https://domainanda.com/admin-access-2024`) tanpa perlu mengubah document root.

### Jika Laravel diletakkan di subfolder (mis. public_html/materweb/)

Jika Anda tidak menaruh Laravel di `public_html` langsung, tetapi di subfolder (mis. `public_html/materweb/`):

1. Di cPanel, atur **document root** ke `public_html/materweb/public`, **atau**
2. Taruh **.htaccess** di dalam `public_html/materweb/` (isi sama seperti .htaccess root di atas), lalu akses situs lewat `https://domainanda.com/materweb/` (biasanya perlu penyesuaian `APP_URL` dan asset di Laravel).

Disarankan: taruh seluruh Laravel langsung di `public_html` dan gunakan .htaccess root seperti di atas.

## Fitur Error Handling

Aplikasi sekarang memiliki:
- Error handling untuk koneksi database
- Fallback data jika database tidak bisa diakses
- Error message yang user-friendly
- Logging error untuk debugging

## Catatan Penting

- Aplikasi akan tetap bisa diakses meskipun ada masalah database
- Data akan kosong tapi tidak akan error
- Error akan di-log untuk debugging
- User akan melihat pesan error yang informatif
