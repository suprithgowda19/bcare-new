@extends('layouts.admin')

@section('title', 'View Workflow')
@section('page_title', 'Escalation Railroad Details')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.master.workflows.index') }}">Workflows</a></li>
    <li class="breadcrumb-item active">View Railroad</li>
@endsection

@push('css')
<style>
    .workflow-timeline { position: relative; padding-left: 3rem; margin-top: 1rem; }
    .workflow-timeline::before {
        content: ''; position: absolute; left: 15px; top: 0; bottom: 0;
        width: 3px; background: #e0e7ff; border-radius: 10px;
    }
    .timeline-item { position: relative; margin-bottom: 2rem; }
    .timeline-marker {
        position: absolute; left: -43px; width: 28px; height: 28px;
        border-radius: 50%; background: #fff; border: 4px solid #6366f1;
        z-index: 1; box-shadow: 0 0 0 4px #f0f4ff;
    }
    .timeline-content {
        background: #ffffff; border-radius: 15px; padding: 1.2rem;
        border: 1px solid #eef2ff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .sla-tag { background: #f5f3ff; color: #7c3aed; font-weight: 700; font-size: 0.75rem; border: 1px solid #ddd6fe; }
    .lock-banner { background-color: #fff7ed; border: 1px solid #ffedd5; border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        {{-- Sidebar: Track Meta --}}
        <div class="col-xl-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase mb-3 letter-spacing-1">Track Identity</h6>
                    
                    <div class="mb-4">
                        <label class="text-muted small d-block">Departmental Category</label>
                        <span class="h5 fw-bold text-indigo">{{ $workflow->category->name }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small d-block">Sub-Category Scope</label>
                        <span class="badge bg-light-primary text-primary px-3 py-2">
                            {{ $workflow->subcategory->name ?? 'General (Applies to All)' }}
                        </span>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="p-3 border rounded bg-light text-center">
                                <small class="text-muted d-block">Total Levels</small>
                                <span class="h4 fw-bold">{{ $workflow->steps->count() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded bg-light text-center">
                                <small class="text-muted d-block">Total SLA</small>
                                <span class="h4 fw-bold text-primary">{{ $workflow->steps->sum('sla_hours') }}h</span>
                            </div>
                        </div>
                    </div>

                    {{-- Usage Check (Controller Logic Alignment) --}}
                    @php 
                        $isLocked = \App\Models\Complaint::where('workflow_id', $workflow->id)->exists(); 
                    @endphp

                    @if($isLocked)
                        <div class="lock-banner p-3 mb-4">
                            <div class="d-flex align-items-center text-warning">
                                <i class="bi bi-lock-fill fs-5 me-2"></i>
                                <span class="small fw-bold">Live System Lock</span>
                            </div>
                            <p class="small text-muted mb-0 mt-1">This railroad is currently handling active complaints. Structural edits are disabled to maintain data integrity.</p>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        @if(!$isLocked)
                            <a href="{{ route('admin.master.workflows.edit', $workflow->id) }}" class="btn btn-indigo shadow-sm py-2">
                                <i class="bi bi-pencil-square me-2"></i>Edit Workflow
                            </a>
                        @endif
                        <a href="{{ route('admin.master.workflows.index') }}" class="btn btn-outline-secondary py-2">
                            Return to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main: The Railroad Path --}}
        <div class="col-xl-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="fw-bold mb-0">Railroad Sequence Visualization</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="workflow-timeline">
                        @foreach($workflow->steps as $step)
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-indigo-soft text-indigo fw-700">STATION {{ $step->step_number }}</span>
                                        <span class="badge sla-tag px-3 py-2">
                                            <i class="bi bi-stopwatch me-1"></i>
                                            {{ $step->sla_hours }} Hours Max
                                        </span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">{{ $step->designation->name }}</h5>
                                    <p class="text-muted small mb-0">
                                        Complaints exceeding <strong>{{ $step->sla_hours }} hours</strong> at this station will trigger the <code>WorkflowTransitionService</code> auto-escalation engine.
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        {{-- Final End Node --}}
                        <div class="timeline-item mb-0">
                            <div class="timeline-marker" style="border-color: #10b981; background: #10b981;"></div>
                            <div class="timeline-content" style="background: #f0fdf4; border-color: #dcfce7;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white rounded-circle p-2 me-3 border border-success">
                                        <i class="bi bi-flag-fill text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-success mb-0">Resolution Terminal</h6>
                                        <p class="small text-success opacity-75 mb-0">Point of final feedback and ticket closure.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection