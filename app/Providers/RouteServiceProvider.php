<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     * Untuk aplikasi admin, redirect ke dashboard admin.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Form publik: batasi per IP agar bot tidak bisa membanjiri komentar/kontak.
        RateLimiter::for('comments', function (Request $request) {
            return [
                Limit::perMinute(3)->by('comments-min:' . $request->ip()),
                Limit::perDay(20)->by('comments-day:' . $request->ip()),
            ];
        });

        RateLimiter::for('contact', function (Request $request) {
            return [
                Limit::perMinute(2)->by('contact-min:' . $request->ip()),
                Limit::perDay(10)->by('contact-day:' . $request->ip()),
            ];
        });

        RateLimiter::for('likes', function (Request $request) {
            return Limit::perMinute(30)->by('likes:' . $request->ip());
        });

        RateLimiter::for('social-read', function (Request $request) {
            return Limit::perMinute(120)->by('social-read:' . $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
