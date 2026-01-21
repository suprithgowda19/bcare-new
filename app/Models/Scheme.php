<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * @author Suprith Gowda S V
     */
    protected $fillable = [
        'title',
        'count',
        'image',
        'status',
    ];

    /**
     * Scope a query to only include active schemes.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}