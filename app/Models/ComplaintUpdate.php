<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintUpdate extends Model
{
    protected $fillable = [
        'complaint_id',
        'acted_by_user_id',
        'action_type',
        'old_status',
        'new_status',
        'remarks',
        'images',
        'is_public',
    ];

    protected $casts = [
        'images'     => 'array',
        'is_public'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function actedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acted_by_user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
