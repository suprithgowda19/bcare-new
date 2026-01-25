<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workflow extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(WorkflowStep::class)
                    ->orderBy('step_number', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function firstStep(): ?WorkflowStep
    {
        return $this->steps()->orderBy('step_number')->first();
    }

    public function getStepByNumber(int $number): ?WorkflowStep
    {
        return $this->steps()
                    ->where('step_number', $number)
                    ->first();
    }

    public function isSubcategoryBased(): bool
    {
        return ! is_null($this->subcategory_id);
    }
}
