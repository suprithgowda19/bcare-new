<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'about', 
        'content', 
        'image', 
        'status'
    ];

    /**
     * Scope to fetch only active news.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Accessor for full image URL.
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}