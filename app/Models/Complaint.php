<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    protected $fillable = [
        'user_id',
        'ward_id',
        'category_id',
        'subcategory_id',

        'workflow_id',
        'current_step_id',

        'subject',
        'message',
        'address',
        'priority',
        'latitude',
        'longitude',
        'images',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'images'      => 'array',
        'resolved_at' => 'datetime',
        'due_at'      => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    public function currentStep(): BelongsTo
    {
        return $this->belongsTo(WorkflowStep::class, 'current_step_id');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(ComplaintUpdate::class)
                    ->orderBy('created_at', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /*
    |--------------------------------------------------------------------------
    | Basic Helpers
    |--------------------------------------------------------------------------
    */

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }
}
