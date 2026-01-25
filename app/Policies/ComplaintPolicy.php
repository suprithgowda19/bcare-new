<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Complaint;
use App\Models\WorkflowStep;

class ComplaintPolicy
{
    /*
    |--------------------------------------------------------------------------
    | View Any
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $user): bool
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | View Single Complaint
    |--------------------------------------------------------------------------
    */

    public function view(User $user, Complaint $complaint): bool
    {
        // Admin can see everything
        if ($user->hasRole('admin')) {
            return true;
        }

        // Public can see only their own complaints
        if ($user->hasRole('public')) {
            return $complaint->user_id === $user->id;
        }

        // Staff logic
        if ($user->hasRole('staff') && $user->status === 'active') {

            // Must belong to same ward
            if (! $user->wards()->where('ward_id', $complaint->ward_id)->exists()) {
                return false;
            }

            // Must have workflow
            if (! $complaint->workflow_id || ! $complaint->currentStep) {
                return false;
            }

            // Get staff step inside workflow
            $staffStep = WorkflowStep::where('workflow_id', $complaint->workflow_id)
                ->where('designation_id', $user->designation_id)
                ->first();

            if (! $staffStep) {
                return false; // Staff not part of this workflow
            }

            // Progressive visibility:
            // Staff can see if complaint has reached or passed their step
            return $complaint->currentStep->step_number >= $staffStep->step_number;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Update (Act / Push Step)
    |--------------------------------------------------------------------------
    */

    public function update(User $user, Complaint $complaint): bool
    {
        // Admin override
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('staff') && $user->status === 'active') {

            if (! $complaint->currentStep) {
                return false;
            }

            // Must belong to ward
            if (! $user->wards()->where('ward_id', $complaint->ward_id)->exists()) {
                return false;
            }

            // Only current step designation can act
            return $complaint->currentStep->designation_id === $user->designation_id;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(User $user, Complaint $complaint): bool
    {
        return $user->hasRole('admin');
    }
}
