<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'priority',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        $now = now();
        return $query->where(function($q) use ($now) {
            $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
        })->where(function($q) use ($now) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
        });
    }

    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Get all of the announcement's likes.
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Get all of the announcement's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get approved comments for the announcement.
     */
    public function approvedComments()
    {
        return $this->comments()->approved();
    }

    /**
     * Get likes count for the announcement.
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    /**
     * Get comments count for the announcement.
     */
    public function getCommentsCountAttribute()
    {
        return $this->approvedComments()->count();
    }
}
