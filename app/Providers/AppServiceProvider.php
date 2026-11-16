<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FORCE_HTTPS di .env; bawaan: aktif di semua environment selain local.
        // Set false hanya jika domain belum punya SSL.
        if (config('app.force_https')) {
            URL::forceScheme('https');
        }
    }
}
