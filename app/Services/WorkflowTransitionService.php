<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\ComplaintUpdate;
use Illuminate\Support\Facades\DB;

class WorkflowTransitionService
{
    public function moveToNextStep(
        Complaint $complaint,
        ?string $remarks = null,
        array $images = [],
        ?int $actedByUserId = null // Important for scheduler support
    ): void {

        DB::transaction(function () use ($complaint, $remarks, $images, $actedByUserId) {

            // Lock row for concurrency safety
            $complaint = Complaint::where('id', $complaint->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$complaint->currentStep) {
                throw new \Exception('No active workflow step.');
            }

            $currentStep = $complaint->currentStep;

            // If triggered by staff (not scheduler), enforce authorization
            if ($actedByUserId === null) {

                $user = auth()->user();

                if (!$user || $currentStep->designation_id !== $user->designation_id) {
                    abort(403, 'You are not allowed to act on this step.');
                }

                $actedByUserId = $user->id;
            }

            $nextStep = $currentStep->nextStep();

            if (!$nextStep) {

                // Final step → resolve complaint
                $complaint->update([
                    'status'      => 'resolved',
                    'resolved_at' => now(),
                    'due_at'      => null,
                ]);

            } else {

                // Move to next step and reset SLA
                $complaint->update([
                    'current_step_id' => $nextStep->id,
                    'status'          => 'in_progress',
                    'due_at'          => now()->addHours($nextStep->sla_hours),
                ]);
            }

            // Log update entry
            ComplaintUpdate::create([
                'complaint_id'     => $complaint->id,
                'acted_by_user_id' => $actedByUserId,
                'action_type'      => 'status_change',
                'remarks'          => $remarks,
                'images'           => $images ?: null,
                'is_public'        => true,
            ]);
        });
    }
}
