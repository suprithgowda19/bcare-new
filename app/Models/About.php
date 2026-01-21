<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'content', 
        'image', 
        'status'
    ];

    /**
     * Scope to fetch only active records.
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
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}