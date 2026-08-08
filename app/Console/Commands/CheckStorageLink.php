<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:check-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek apakah storage symlink sudah dibuat dan valid';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $symlinkPath = public_path('storage');
        $targetPath = storage_path('app/public');

        $this->info('Memeriksa storage symlink...');
        $this->line('');

        // Cek apakah target directory ada
        if (!File::exists($targetPath)) {
            $this->warn("Target directory tidak ditemukan: {$targetPath}");
            $this->info("Membuat directory...");
            File::makeDirectory($targetPath, 0755, true);
            $this->info("✓ Directory dibuat.");
        } else {
            $this->info("✓ Target directory ada: {$targetPath}");
        }

        // Cek apakah symlink ada
        if (!File::exists($symlinkPath)) {
            $this->error("✗ Symlink belum dibuat: {$symlinkPath}");
            $this->line('');
            $this->info("Untuk membuat symlink, jalankan:");
            $this->line("  php artisan storage:link");
            return self::FAILURE;
        }

        // Cek apakah itu symlink atau directory biasa
        if (is_link($symlinkPath)) {
            $linkTarget = readlink($symlinkPath);
            $this->info("✓ Symlink ditemukan: {$symlinkPath}");
            $this->info("  → Menunjuk ke: {$linkTarget}");
            
            if ($linkTarget === '../storage/app/public' || $linkTarget === storage_path('app/public')) {
                $this->info("✓ Symlink valid!");
            } else {
                $this->warn("⚠ Symlink menunjuk ke path yang tidak biasa: {$linkTarget}");
            }
        } elseif (is_dir($symlinkPath)) {
            $this->warn("⚠ {$symlinkPath} adalah directory, bukan symlink.");
            $this->info("  Ini mungkin normal di beberapa hosting, tapi pastikan isinya sama dengan storage/app/public");
        } else {
            $this->error("✗ Path ada tapi bukan symlink atau directory: {$symlinkPath}");
            return self::FAILURE;
        }

        // Test: cek apakah ada file di storage/app/public
        $testFiles = File::files($targetPath);
        if (count($testFiles) > 0) {
            $this->info("✓ Ditemukan " . count($testFiles) . " file di storage/app/public");
        } else {
            $this->info("ℹ Belum ada file di storage/app/public (normal jika belum upload)");
        }

        return self::SUCCESS;
    }
}
