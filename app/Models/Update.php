<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'tag_name', 
        'about', 
        'content', 
        'image', 
        'status'
    ];

    /**
     * Scope to fetch only active updates.
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