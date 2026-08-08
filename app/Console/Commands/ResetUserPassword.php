<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password {email : Email user (contoh: admin@webdomain.com)} {password : Password baru}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password user admin berdasarkan email';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Cari user dengan email (case-insensitive)
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();

        if (! $user) {
            $this->error("User dengan email \"{$email}\" tidak ditemukan.");
            $this->line('');
            $this->info('Daftar user yang ada di database:');
            User::all(['id', 'name', 'email'])->each(function ($u) {
                $this->line("  - ID: {$u->id}, Name: {$u->name}, Email: {$u->email}");
            });
            return self::FAILURE;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("✓ Password untuk {$user->email} (nama: {$user->name}) berhasil direset.");
        $this->line("  Email: {$user->email}");
        $this->line("  Password baru: {$password}");
        return self::SUCCESS;
    }
}
