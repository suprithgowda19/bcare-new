<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'ward_id',
        'subcategory_id',
        'subject',
        'message',
        'address',
        'priority',
        'latitude',
        'longitude',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array', 
    ];

    /**
     * Get the citizen who filed the complaint.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category that the complaint belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory. 
     * Note: Renamed to subCategory (camelCase) to match Controller eager loading.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    /**
     * Get the ward where the complaint is located.
     */
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    /**
     * Get the timeline of updates for this complaint.
     */
    public function updates(): HasMany
    {
        return $this->hasMany(ComplaintUpdate::class);
    }
}