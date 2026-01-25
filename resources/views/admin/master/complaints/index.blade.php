@extends('layouts.admin')

@section('title', 'Complaints')
@section('page_title', 'Citizen Complaints Monitor')

@section('breadcrumb')
    <li class="breadcrumb-item active">Complaints</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .sla-breached {
            border-left: 4px solid #ef4444 !important;
            background-color: #fef2f2 !important;
        }
        .station-badge {
            background-color: #f0f2f5;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .priority-dot {
            height: 8px;
            width: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
    </style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 font-700">Public Grievance Monitor</h4>
            <p class="text-muted small mb-0">Track live ticket movement through departmental railroads.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-light-danger text-danger border border-danger p-2">
                <i class="bi bi-exclamation-octagon me-1"></i> SLA Breached Tickets Highlighted
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="complaints-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Citizen</th>
                            <th>Category & Scope</th>
                            <th>Current Station</th>
                            <th>Priority</th>
                            <th>SLA / Deadline</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($complaints as $complaint)
                            @php 
                                $isBreached = $complaint->due_at && $complaint->due_at->isPast() && $complaint->status !== 'resolved';
                            @endphp
                            <tr class="{{ $isBreached ? 'sla-breached' : '' }}">
                                
                                {{-- Ticket ID --}}
                                <td class="fw-bold text-dark">
                                    SP-{{ $complaint->id }}
                                </td>

                                {{-- Citizen --}}
                                <td>
                                    <div class="fw-600">{{ $complaint->user->name ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $complaint->ward->name ?? 'No Ward' }}</small>
                                </td>

                                {{-- Category --}}
                                <td>
                                    <div class="small fw-bold text-indigo">{{ $complaint->category->name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">
                                        {{ $complaint->subcategory->name ?? 'General' }}
                                    </div>
                                </td>

                                {{-- Current Station (Designation) --}}
                                <td>
                                    @if($complaint->status === 'resolved')
                                        <span class="text-success small fw-bold"><i class="bi bi-check-all me-1"></i>Closed</span>
                                    @else
                                        <span class="station-badge text-uppercase">
                                            <i class="bi bi-geo-alt-fill me-1 text-primary"></i>
                                            {{ $complaint->currentStep->designation->name ?? 'Initial Stage' }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Priority --}}
                                <td>
                                    @php
                                        $pMap = match ($complaint->priority) {
                                            'urgent' => ['bg' => 'bg-danger', 'text' => 'text-danger', 'light' => 'bg-light-danger'],
                                            'high' => ['bg' => 'bg-warning', 'text' => 'text-warning', 'light' => 'bg-light-warning'],
                                            'medium' => ['bg' => 'bg-info', 'text' => 'text-info', 'light' => 'bg-light-info'],
                                            default => ['bg' => 'bg-success', 'text' => 'text-success', 'light' => 'bg-light-success'],
                                        };
                                    @endphp
                                    <span class="badge {{ $pMap['light'] }} {{ $pMap['text'] }} rounded-pill px-3">
                                        <span class="priority-dot {{ $pMap['bg'] }}"></span>
                                        {{ strtoupper($complaint->priority) }}
                                    </span>
                                </td>

                                {{-- SLA / Deadline --}}
                                <td>
                                    @if($complaint->status === 'resolved')
                                        <small class="text-muted">Completed</small>
                                    @elseif($complaint->due_at)
                                        <div class="fw-bold {{ $isBreached ? 'text-danger' : 'text-dark' }}" style="font-size: 0.8rem;">
                                            {{ $complaint->due_at->format('d M, h:i A') }}
                                        </div>
                                        <small class="{{ $isBreached ? 'text-danger fw-bold' : 'text-muted' }}" style="font-size: 0.7rem;">
                                            {{ $isBreached ? 'Breached ' . $complaint->due_at->diffForHumans() : 'Due ' . $complaint->due_at->diffForHumans() }}
                                        </small>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>

                                {{-- Status Badge --}}
                                <td>
                                    @php
                                        $sMap = match ($complaint->status) {
                                            'resolved' => 'bg-success',
                                            'in_progress' => 'bg-primary',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $sMap }} px-2 py-1">
                                        {{ strtoupper(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-end">
                                    <a href="{{ route('admin.master.complaints.show', $complaint->id) }}"
                                        class="btn btn-sm btn-white border shadow-sm px-3">
                                        <i class="bi bi-eye-fill text-primary me-1"></i> Audit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>