<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class RouteHelper
{
    /**
     * Generate route with safe slug handling
     */
    public static function safeRoute($routeName, $slug, $fallback = '#')
    {
        try {
            if (empty($slug)) {
                return $fallback;
            }
            
            return route($routeName, $slug);
        } catch (\Exception $e) {
            \Log::warning("Route generation failed for {$routeName} with slug: {$slug}. Error: " . $e->getMessage());
            return $fallback;
        }
    }

    /**
     * Generate route with fallback message
     */
    public static function safeRouteWithMessage($routeName, $slug, $message = 'Detail tidak tersedia')
    {
        try {
            if (empty($slug)) {
                return "javascript:alert('{$message}')";
            }
            
            return route($routeName, $slug);
        } catch (\Exception $e) {
            \Log::warning("Route generation failed for {$routeName} with slug: {$slug}. Error: " . $e->getMessage());
            return "javascript:alert('{$message}')";
        }
    }
}
