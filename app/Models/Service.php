<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'content', 
        'image',
        'status'
    ];

    /**
     * Scope to fetch only active services for the frontend.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}