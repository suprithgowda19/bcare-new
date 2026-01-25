<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Designation extends Model
{
    /**
     * Updated Mass assignable fields to include departmental context.
     */
    protected $fillable = [
        'name', 
        'category_id', 
        'subcategory_id'
    ];

    /**
     * Relationship: Designation -> Category
     * Every designation must belong to a primary department.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: Designation -> SubCategory
     * This remains optional (nullable) as per your requirement.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    /**
     * Relationship: Designation -> Users
     * Finds all staff members holding this specific departmental role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship: Designation -> WorkflowSteps
     * Links this role to specific stages in your grievance tracks.
     */
    public function workflowSteps(): HasMany
    {
        return $this->hasMany(WorkflowStep::class);
    }
}