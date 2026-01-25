<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminComplaintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin: View All Complaints
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $complaints = Complaint::with([
                'category:id,name',
                'subCategory:id,name',
                'ward:id,name',
                'user:id,name',
                'currentStep:id,step_number,workflow_id'
            ])
            ->latest()
            ->paginate(10);

        return view('admin.master.complaints.index', compact('complaints'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin: View Single Complaint (Full Timeline)
    |--------------------------------------------------------------------------
    */

    public function show(Complaint $complaint)
    {
        $complaint->load([
            'category:id,name',
            'subCategory:id,name',
            'ward:id,name',
            'user:id,name,phone',
            'updates.actedBy:id,name',
            'currentStep',
            'workflow.steps'
        ]);

        return view('admin.master.complaints.show', compact('complaint'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin: SLA Breached Complaints (True Escalation View)
    |--------------------------------------------------------------------------
    */

    public function flagged(Request $request)
    {
        $complaints = Complaint::where('status', 'in_progress')
            ->whereNotNull('due_at')
            ->where('due_at', '<=', now())
            ->with([
                'category:id,name',
                'subCategory:id,name',
                'ward:id,name',
                'user:id,name',
                'currentStep'
            ])
            ->orderBy('due_at', 'asc') // oldest breach first
            ->paginate(15);

        return view('admin.master.complaints.flagged', compact('complaints'));
    }
}
