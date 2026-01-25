<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintUpdateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard – Progressive Visibility + Auto Escalation
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->autoEscalateExpiredComplaints(); // ← SLA check

        $staff = Auth::user();

        $complaints = Complaint::with(['currentStep', 'ward'])
            ->latest()
            ->get()
            ->filter(function ($complaint) use ($staff) {
                return $staff->can('view', $complaint);
            });

        return view('staff.dashboard', compact('complaints'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show Complaint
    |--------------------------------------------------------------------------
    */

    public function show(Complaint $complaint)
    {
        $this->authorize('view', $complaint);

        $complaint->load([
            'category',
            'subcategory',
            'user',
            'updates.actedBy',
            'currentStep',
            'workflow.steps'
        ]);

        return view('staff.complaints.show', compact('complaint'));
    }

    /*
    |--------------------------------------------------------------------------
    | Push to Next Step
    |--------------------------------------------------------------------------
    */

    public function push(Request $request, Complaint $complaint)
    {
        $this->authorize('update', $complaint);

        $request->validate([
            'remarks'  => 'nullable|string',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('complaint_updates', 'public');
            }
        }

        app(\App\Services\WorkflowTransitionService::class)
            ->moveToNextStep(
                $complaint,
                $request->remarks,
                $imagePaths
            );

        return redirect()
            ->route('staff.dashboard')
            ->with('success', 'Moved to next step successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Add Comment
    |--------------------------------------------------------------------------
    */

    public function comment(Request $request, Complaint $complaint)
    {
        $this->authorize('view', $complaint);

        $request->validate([
            'remarks'  => 'required|string|min:5',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('complaint_updates', 'public');
            }
        }

        ComplaintUpdate::create([
            'complaint_id'     => $complaint->id,
            'acted_by_user_id' => Auth::id(),
            'action_type'      => 'comment',
            'remarks'          => $request->remarks,
            'images'           => $imagePaths ?: null,
            'is_public'        => true,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Resolved Complaints
    |--------------------------------------------------------------------------
    */

    public function solvedComplaints()
    {
        $staff = Auth::user();

        $complaints = Complaint::where('status', 'resolved')
            ->latest()
            ->get()
            ->filter(function ($complaint) use ($staff) {
                return $staff->can('view', $complaint);
            });

        return view('staff.complaints.solved', compact('complaints'));
    }


    /*
    |--------------------------------------------------------------------------
    | AUTO ESCALATION METHOD (Controller-Level SLA Engine)
    |--------------------------------------------------------------------------
    */

    private function autoEscalateExpiredComplaints(): void
    {
        $expiredComplaints = Complaint::where('status', 'in_progress')
            ->whereNotNull('due_at')
            ->where('due_at', '<=', now())
            ->get();

        foreach ($expiredComplaints as $complaint) {

            app(\App\Services\WorkflowTransitionService::class)
                ->moveToNextStep(
                    $complaint,
                    'Automatically escalated due to SLA breach.',
                    [],
                    null // system escalation
                );
        }
    }
}
