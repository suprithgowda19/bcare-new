<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'content', 
        'status'
    ];

    /**
     * Scope to fetch only active records.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}