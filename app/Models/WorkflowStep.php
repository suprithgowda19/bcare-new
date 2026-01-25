<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowStep extends Model
{
    protected $fillable = [
        'workflow_id',
        'step_number',
        'designation_id',
        'sla_hours',
    ];

    protected $casts = [
        'step_number' => 'integer',
        'sla_hours'   => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function nextStep(): ?WorkflowStep
    {
        return WorkflowStep::where('workflow_id', $this->workflow_id)
            ->where('step_number', $this->step_number + 1)
            ->first();
    }

    public function isFinalStep(): bool
    {
        return ! WorkflowStep::where('workflow_id', $this->workflow_id)
            ->where('step_number', '>', $this->step_number)
            ->exists();
    }
}
