@extends('layouts.staff')

@section('title', 'Staff Complaints Dashboard')

@section('style')
<style>
    .table>:not(caption)>*>* {
        border: 1px solid #00000038 !important;
        font-size: 14px !important;
    }
    .section-divider {
        background-color: #f0f0f0;
        padding: 10px 15px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        color: #666;
    }
    .sla-warning {
        border-left: 3px solid #f33b3b !important;
    }
</style>
@endsection

@section('content')

    {{-- SECTION 1: ACTIONABLE TICKETS --}}
    <div class="section-divider mt-3">Tickets at My Desk (Pending)</div>
    <div class="card card-style">
        <div class="content text-center pt-4" style="overflow-x:auto;">
            <table class="table table-borderless text-center rounded-sm shadow-l">
                <thead>
                    <tr style="background-color:#e45b44 !important;" class="text-white">
                        <th>Sl No.</th>
                        <th>Ticket ID</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingTickets as $complaint)
                        <tr class="{{ ($complaint->due_at && $complaint->due_at->isPast()) ? 'sla-warning' : '' }}">
                            <td>{{ ($pendingTickets->currentPage() - 1) * $pendingTickets->perPage() + $loop->iteration }}</td>
                            <td class="font-700">#{{ $complaint->id }}</td>
                            <td>{{ $complaint->category->name ?? 'General' }}</td>
                            <td>
                                <span class="badge {{ $complaint->priority == 'urgent' ? 'bg-red-dark' : 'bg-blue-dark' }} text-white">
                                    {{ strtoupper($complaint->priority ?? 'Normal') }}
                                </span>
                            </td>
                            <td>
                                @if($complaint->due_at)
                                    <span class="font-11 {{ $complaint->due_at->isPast() ? 'color-red-dark font-700' : '' }}">
                                        {{ $complaint->due_at->format('d M') }}
                                    </span>
                                @else
                                    <span class="opacity-30">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning text-white">{{ strtoupper($complaint->status) }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a class="btn btn-sm" style="background-color: rgba(0,0,0,0.05); border-color:#0000005e;"
                                       href="{{ route('staff.complaints.show', $complaint->id) }}">
                                        <i class="fa fa-edit" style="color:black"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-4 opacity-50">No pending complaints at your station.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if ($pendingTickets->hasPages()) 
                <div class="px-3">
                    {{ $pendingTickets->appends(['activity_page' => $myActivity->currentPage()])->links() }} 
                </div>
            @endif
        </div>
    </div>

    {{-- SECTION 2: TRACKING ACTIVITY --}}
    <div class="section-divider">Recently Handled (Tracking)</div>
    <div class="card card-style mb-5">
        <div class="content text-center pt-4" style="overflow-x:auto;">
            <table class="table table-borderless text-center rounded-sm shadow-l">
                <thead>
                    <tr style="background-color:#4A89DC !important;" class="text-white">
                        <th>Sl No.</th>
                        <th>Ticket ID</th>
                        <th>Current Station</th>
                        <th>Last Update</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myActivity as $complaint)
                        <tr>
                            <td>{{ ($myActivity->currentPage() - 1) * $myActivity->perPage() + $loop->iteration }}</td>
                            <td class="font-700">#{{ $complaint->id }}</td>
                            <td>
                                <span class="font-12 font-600">
                                    {{ $complaint->currentStep->designation->name ?? 'Resolved' }}
                                </span>
                            </td>
                            <td class="font-11">{{ $complaint->updated_at->diffForHumans() }}</td>
                            <td>
                                <span class="badge {{ $complaint->status == 'resolved' ? 'bg-green-dark' : 'bg-secondary' }} text-white">
                                    {{ strtoupper($complaint->status) }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm" style="background-color: rgba(0,0,0,0.05); border-color:#0000005e;"
                                   href="{{ route('staff.complaints.show', $complaint->id) }}">
                                    <i class="fa fa-eye" style="color:black"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-4 opacity-50">No recently handled tickets.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if ($myActivity->hasPages()) 
                <div class="px-3">
                    {{ $myActivity->appends(['pending_page' => $pendingTickets->currentPage()])->links() }} 
                </div>
            @endif
        </div>
    </div>

@endsection