@extends('layouts.admin')

@section('title', 'Flagged Complaints')
@section('page_title', 'SLA Breach Monitor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.master.complaints.index') }}">Monitor</a></li>
    <li class="breadcrumb-item active">Critical Flags</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .overdue-badge {
            animation: pulse-red 2s infinite;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        .station-indicator {
            font-size: 0.75rem;
            color: #64748b;
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }
        .critical-row {
            background-color: #fffafb !important;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 font-700 text-danger">High-Priority SLA Violations</h4>
            <p class="text-muted small mb-0">Complaints that have exceeded the defined threshold and require administrative intervention.</p>
        </div>
        
        <div class="d-flex align-items-center bg-white p-2 rounded shadow-sm border">
            <label class="me-3 mb-0 text-nowrap small fw-bold text-uppercase opacity-70">
                <i class="bi bi-filter-left me-1"></i> Threshold:
            </label>
            <form action="{{ route('admin.master.complaints.flagged') }}" method="GET" id="thresholdForm">
                <select name="days" class="form-select form-select-sm border-0 bg-light fw-bold" onchange="this.form.submit()">
                    @foreach([1, 2, 3, 5, 7, 10, 15] as $day)
                        <option value="{{ $day }}" {{ $daysThreshold == $day ? 'selected' : '' }}>
                            {{ $day }} {{ Str::plural('Day', $day) }} & Older
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="flagged-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Citizen & Ward</th>
                            <th>Category Scope</th>
                            <th>Current Station</th>
                            <th class="text-center">Total Aging</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complaints as $complaint)
                            <tr class="critical-row">
                                {{-- Ticket ID --}}
                                <td>
                                    <span class="fw-bold text-dark">SP-{{ $complaint->id }}</span>
                                    @if($complaint->priority == 'urgent')
                                        <i class="bi bi-lightning-fill text-danger ms-1" title="Urgent Priority"></i>
                                    @endif
                                </td>

                                {{-- User & Ward --}}
                                <td>
                                    <div class="fw-600">{{ $complaint->user->name ?? 'Anonymous' }}</div>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $complaint->ward->name ?? 'Unassigned' }}</small>
                                </td>

                                {{-- Category --}}
                                <td>
                                    <div class="small fw-bold text-primary">{{ $complaint->category->name ?? 'N/A' }}</div>
                                    <div class="text-muted small" style="font-size: 0.7rem;">{{ $complaint->subcategory->name ?? 'General' }}</div>
                                </td>

                                {{-- Current Railroad Station --}}
                                <td>
                                    <span class="station-indicator text-uppercase">
                                        {{ $complaint->currentStep->designation->name ?? 'Initial Stage' }}
                                    </span>
                                </td>

                                {{-- Aging with Pulse Effect --}}
                                <td class="text-center">
                                    <span class="badge bg-danger overdue-badge px-3 py-2">
                                       {{ (int) $complaint->created_at->diffInDays() }} DAYS OVERDUE
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="badge bg-light-warning text-warning border border-warning px-2">
                                        {{ strtoupper(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-end">
                                    <a href="{{ route('admin.master.complaints.show', $complaint->id) }}" class="btn btn-sm btn-indigo text-white shadow-sm">
                                        <i class="bi bi-shield-exclamation me-1"></i> Audit & Intervene
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($complaints, 'links'))
                <div class="mt-4">
                    {{ $complaints->appends(['days' => $daysThreshold])->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#flagged-table').DataTable({
                ordering: true,
                paging: false, 
                info: false,
                order: [[4, 'desc']], // Sort by aging by default
                dom: '<"d-flex justify-content-between align-items-center mb-3"f>rt',
                language: {
                    search: "",
                    searchPlaceholder: "Quick search tickets..."
                }
            });
        });
    </script>
@endpush