<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'user_ip',
        'user_agent',
    ];

    /**
     * Get the parent likeable model (post, announcement, etc.).
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    /**
     * Check if IP already liked this item
     */
    public static function hasLiked($likeableType, $likeableId, $userIp)
    {
        return static::where('likeable_type', $likeableType)
                    ->where('likeable_id', $likeableId)
                    ->where('user_ip', $userIp)
                    ->exists();
    }

    /**
     * Toggle like for an item
     */
    public static function toggleLike($likeableType, $likeableId, $userIp, $userAgent = null)
    {
        $like = static::where('likeable_type', $likeableType)
                     ->where('likeable_id', $likeableId)
                     ->where('user_ip', $userIp)
                     ->first();

        if ($like) {
            $like->delete();
            return false; // Unliked
        } else {
            static::create([
                'likeable_type' => $likeableType,
                'likeable_id' => $likeableId,
                'user_ip' => $userIp,
                'user_agent' => $userAgent,
            ]);
            return true; // Liked
        }
    }
}
