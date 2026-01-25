<?php

namespace App\Services;

use App\Models\Workflow;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class WorkflowResolver
{
    public function attachWorkflow(Complaint $complaint): void
    {
        DB::transaction(function () use ($complaint) {

            // Reload inside transaction for safety
            $complaint = Complaint::where('id', $complaint->id)
                ->lockForUpdate()
                ->first();

            // Find matching workflow (Category + Subcategory OR category-only)
            $workflow = Workflow::where('category_id', $complaint->category_id)
                ->where(function ($query) use ($complaint) {
                    $query->where('subcategory_id', $complaint->subcategory_id)
                          ->orWhereNull('subcategory_id');
                })
                ->where('is_active', true)
                ->first();

            if (! $workflow) {
                return;
            }

            $firstStep = $workflow->steps()
                                  ->orderBy('step_number', 'asc')
                                  ->first();

            if (! $firstStep) {
                return;
            }

            $complaint->update([
                'workflow_id'     => $workflow->id,
                'current_step_id' => $firstStep->id,
                'status'          => 'in_progress',
                'due_at'          => now()->addHours($firstStep->sla_hours),
            ]);
        });
    }
}
