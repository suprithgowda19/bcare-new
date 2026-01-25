@extends('layouts.admin')

@section('title', 'Complaint Audit')
@section('page_title', 'Audit: Ticket #SP-' . $complaint->id)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.master.complaints.index') }}">Monitor</a></li>
    <li class="breadcrumb-item active">Ticket Audit</li>
@endsection

@push('css')
<style>
    .railroad-track { position: relative; display: flex; justify-content: space-between; margin-bottom: 3rem; padding: 0 20px; }
    .railroad-track::before { content: ''; position: absolute; top: 15px; left: 0; right: 0; height: 4px; background: #e2e8f0; z-index: 1; }
    .railroad-step { position: relative; z-index: 2; text-align: center; width: 100px; }
    .step-dot { width: 34px; height: 34px; border-radius: 50%; background: #fff; border: 4px solid #e2e8f0; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; }
    .step-active .step-dot { border-color: #6366f1; color: #6366f1; box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.1); }
    .step-complete .step-dot { background: #6366f1; border-color: #6366f1; color: #fff; }
    .step-label { font-size: 10px; font-weight: 700; text-uppercase; color: #64748b; }
    
    .timeline-audit { border-left: 2px solid #e2e8f0; padding-left: 20px; position: relative; }
    .timeline-audit-item { position: relative; margin-bottom: 1.5rem; }
    .timeline-audit-item::before { content: ''; position: absolute; left: -27px; top: 5px; width: 12px; height: 12px; border-radius: 50%; background: #cbd5e1; border: 2px solid #fff; }
    .update-img { width: 80px; height: 60px; object-fit: cover; border-radius: 6px; cursor: pointer; transition: transform 0.2s; }
    .update-img:hover { transform: scale(1.1); }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    {{-- 1. SLA & STATUS HEADER --}}
    @php 
        $isBreached = $complaint->due_at && $complaint->due_at->isPast() && $complaint->status !== 'resolved';
    @endphp
    <div class="alert {{ $isBreached ? 'bg-light-danger border-danger' : 'bg-light-primary border-primary' }} d-flex align-items-center mb-4 shadow-sm">
        <div class="me-3">
            <i class="bi {{ $isBreached ? 'bi-exclamation-octagon-fill text-danger' : 'bi-clock-fill text-primary' }} fs-2"></i>
        </div>
        <div>
            <h6 class="mb-0 fw-bold {{ $isBreached ? 'text-danger' : 'text-primary' }}">
                {{ $isBreached ? 'SLA BREACHED: This ticket is overdue' : 'Tracking Resolution Progress' }}
            </h6>
            <small class="text-muted">
                Deadline: {{ $complaint->due_at ? $complaint->due_at->format('d M Y, h:i A') : 'No SLA Assigned' }} 
                ({{ $complaint->due_at ? $complaint->due_at->diffForHumans() : '' }})
            </small>
        </div>
        <div class="ms-auto">
            <span class="badge {{ $complaint->status == 'resolved' ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">
                {{ strtoupper(str_replace('-', ' ', $complaint->status)) }}
            </span>
        </div>
    </div>

    {{-- 2. RAILROAD VISUALIZATION --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-4">
            <h6 class="section-title mb-4 small fw-bold text-uppercase opacity-50">Current Railroad Position</h6>
            <div class="railroad-track">
                @php 
                    $currentStepNum = $complaint->currentStep->step_number ?? 1;
                    $totalSteps = $complaint->workflow->steps->count() ?? 1;
                @endphp

                @foreach($complaint->workflow->steps as $step)
                    @php
                        $statusClass = '';
                        if($complaint->status == 'resolved') $statusClass = 'step-complete';
                        elseif($step->step_number < $currentStepNum) $statusClass = 'step-complete';
                        elseif($step->step_number == $currentStepNum) $statusClass = 'step-active';
                    @endphp
                    <div class="railroad-step {{ $statusClass }}">
                        <div class="step-dot">
                            @if($step->step_number < $currentStepNum || $complaint->status == 'resolved')
                                <i class="bi bi-check-lg"></i>
                            @else
                                {{ $step->step_number }}
                            @endif
                        </div>
                        <div class="step-label">{{ $step->designation->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- 3. COMPLAINT DETAILS --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-file-text me-2"></i>Grievance Statement</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted small fw-bold text-uppercase">Department</div>
                        <div class="col-sm-8">{{ $complaint->category->name }} ({{ $complaint->subCategory->name ?? 'General' }})</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted small fw-bold text-uppercase">Location</div>
                        <div class="col-sm-8">
                            <i class="bi bi-geo-alt-fill text-danger"></i> 
                            Ward: {{ $complaint->ward->name ?? 'N/A' }}<br>
                            <span class="small">{{ $complaint->address }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted small fw-bold text-uppercase">Priority Level</div>
                        <div class="col-sm-8">
                            <span class="badge {{ $complaint->priority == 'urgent' ? 'bg-danger' : 'bg-dark' }}">
                                {{ strtoupper($complaint->priority) }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded border">
                        <p class="mb-0">{{ $complaint->message }}</p>
                    </div>
                </div>
            </div>

            {{-- 4. DETAILED AUDIT TRAIL --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Full Audit History</h6>
                </div>
                <div class="card-body">
                    <div class="timeline-audit">
                        @forelse($complaint->updates as $update)
                            <div class="timeline-audit-item">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold text-dark">{{ $update->actedBy->name ?? 'System Engine' }}</span>
                                    <small class="text-muted">{{ $update->created_at->format('d M, h:i A') }}</small>
                                </div>
                                <div class="badge bg-light text-primary border mb-2">{{ strtoupper($update->action_type) }}</div>
                                <p class="text-muted small mb-2">{{ $update->remarks }}</p>
                                
                                {{-- Show photos attached to this specific update --}}
                                @if($update->images)
                                    <div class="d-flex gap-2 mb-2">
                                        @foreach($update->images as $img)
                                            <img src="{{ asset('storage/' . $img) }}" class="update-img border" onclick="window.open(this.src)">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-inbox text-muted display-4"></i>
                                <p class="text-muted mt-2">No departmental actions recorded yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- 5. CITIZEN CARD --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-light-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px; height:80px;">
                            <i class="bi bi-person-fill text-primary fs-1"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $complaint->user->name ?? 'Anonymous Citizen' }}</h5>
                    <p class="text-muted small mb-3"><i class="bi bi-phone me-1"></i> {{ $complaint->user->phone ?? 'Unlisted' }}</p>
                    <div class="d-flex justify-content-around border-top pt-3 mt-3">
                        <div>
                            <small class="d-block text-muted">Filed</small>
                            <span class="fw-bold">{{ $complaint->created_at->format('d M') }}</span>
                        </div>
                        <div class="border-start"></div>
                        <div>
                            <small class="d-block text-muted">Aging</small>
                            <span class="fw-bold {{ $complaint->created_at->diffInDays() > 3 ? 'text-danger' : '' }}">
                                {{ $complaint->created_at->diffInDays() }} Days
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 6. ORIGINAL EVIDENCE --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">Original Evidence</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @if($complaint->images)
                            @foreach($complaint->images as $img)
                                <div class="col-6">
                                    <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded border" style="height:100px; width:100%; object-fit:cover;" onclick="window.open(this.src)">
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-muted small py-3">No photos attached at filing.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection