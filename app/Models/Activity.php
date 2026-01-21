<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'content', 
        'image', 
        'status'
    ];

    /**
     * Scope to fetch only active activities.
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