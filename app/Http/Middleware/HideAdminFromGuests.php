<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HideAdminFromGuests
{
    /**
     * Sembunyikan panel admin dari tamu: akses /admin tanpa login
     * mengembalikan 404 agar URL login tidak terungkap.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = trim($request->path(), '/');
        $isAdminPath = $path === 'admin' || str_starts_with($path, 'admin/');

        if (Auth::guest() && $isAdminPath) {
            abort(404);
        }

        return $next($request);
    }
}
