<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;

class ComplaintPolicy
{
    /**
     * Determine whether the staff can view a complaint.
     *
     * Rule:
     * - Staff must be assigned to the complaint's ward
     */
    public function view(User $staff, Complaint $complaint): bool
    {
        return $this->staffOwnsWard($staff, $complaint);
    }

    /**
     * Determine whether the staff can update a complaint
     * (classification, priority, metadata).
     *
     * Rule:
     * - Staff must own the ward
     * - Resolved complaints are immutable
     */
    public function update(User $staff, Complaint $complaint): bool
    {
        if ($complaint->status === 'resolved') {
            return false;
        }

        return $this->staffOwnsWard($staff, $complaint);
    }

    /**
     * Determine whether the staff can update complaint status.
     *
     * Rule:
     * - Staff must own the ward
     * - Resolved complaints cannot be changed
     */
    public function updateStatus(User $staff, Complaint $complaint): bool
    {
        if ($complaint->status === 'resolved') {
            return false;
        }

        return $this->staffOwnsWard($staff, $complaint);
    }

    /**
     * Determine whether the staff can view complaint history.
     *
     * Rule:
     * - Same as view permission
     */
    public function viewHistory(User $staff, Complaint $complaint): bool
    {
        return $this->view($staff, $complaint);
    }

    /**
     * Centralized ward ownership check.
     *
     * IMPORTANT:
     * - Uses EXISTS query (DB-level check)
     * - No pluck(), no arrays, no PHP loops
     * - Scales correctly with thousands of wards
     */
    protected function staffOwnsWard(User $staff, Complaint $complaint): bool
    {
        return $staff->wards()
            ->whereKey($complaint->ward_id)
            ->exists();
    }
}
