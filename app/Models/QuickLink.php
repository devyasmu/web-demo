<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'icon',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getResolvedUrlAttribute(): string
    {
        return self::normalizeUrl($this->url);
    }

    public function getIsExternalAttribute(): bool
    {
        return self::isExternalUrl($this->resolved_url);
    }

    public static function normalizeUrl(?string $url): string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return '#';
        }

        if (str_starts_with($url, '/') || str_starts_with($url, '#')) {
            return $url;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $url)) {
            return $url;
        }

        return 'https://' . $url;
    }

    public static function isExternalUrl(string $url): bool
    {
        return (bool) preg_match('/^https?:\/\//i', $url);
    }
}
