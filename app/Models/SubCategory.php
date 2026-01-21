<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'name_kn',
        'image',
        'status'
    ];

    /**
     * Relationship: SubCategory belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor for full image URL.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/images/no-image.png');
    }
}