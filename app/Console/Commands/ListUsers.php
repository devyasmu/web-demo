<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tampilkan daftar semua user di database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $users = User::all(['id', 'name', 'email', 'created_at']);

        if ($users->isEmpty()) {
            $this->warn('Tidak ada user di database.');
            return self::SUCCESS;
        }

        $this->info('Daftar User:');
        $this->line('');

        $headers = ['ID', 'Name', 'Email', 'Created At'];
        $rows = $users->map(function ($user) {
            return [
                $user->id,
                $user->name,
                $user->email,
                $user->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();

        $this->table($headers, $rows);

        return self::SUCCESS;
    }
}
