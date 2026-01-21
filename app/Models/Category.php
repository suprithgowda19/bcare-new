<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_kn',
        'image',
        'status'
    ];

    /**
     * Accessor for full image URL.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/images/no-image.png');
    }
}