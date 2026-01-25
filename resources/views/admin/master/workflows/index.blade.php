@extends('layouts.admin')

@section('title', 'Workflows')
@section('page_title', 'Escalation Railroad Management')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Workflows</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .railroad-badge {
            display: inline-flex;
            align-items: center;
            background: #f8f9ff;
            border: 1px solid #e0e7ff;
            border-radius: 20px;
            padding: 4px 12px;
            color: #6366f1;
            font-weight: 600;
            font-size: 0.8rem;
        }
        .railroad-line {
            width: 20px;
            height: 2px;
            background: #cbd5e1;
            display: inline-block;
            margin: 0 5px;
            vertical-align: middle;
        }
        .status-dot {
            height: 8px;
            width: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 font-700">Departmental Escalation Tracks</h4>
            <p class="text-muted small mb-0">Define how complaints move across designations and set SLA limits.</p>
        </div>
        <a href="{{ route('admin.master.workflows.create') }}" class="btn btn-indigo shadow-sm" style="background-color: #6366f1; color: white;">
            <i class="bi bi-plus-lg me-1"></i> Create New Track
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle" id="workflow-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Sl.No</th>
                            <th>Target Scope</th>
                            <th>Escalation Railroad</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workflows as $index => $wf)
                            <tr>
                                <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                
                                {{-- Scope Column --}}
                                <td>
                                    <div class="fw-bold text-dark">{{ $wf->category->name }}</div>
                                    <div class="small text-muted">
                                        {{ $wf->subcategory->name ?? 'All Sub-categories' }}
                                    </div>
                                </td>

                                {{-- Railroad Preview --}}
                                <td>
                                    <div class="railroad-badge">
                                        <i class="bi bi-layers-half me-2"></i>
                                        {{ $wf->steps_count }} Station(s) 
                                    </div>
                                    @if($wf->steps_count > 0)
                                        <span class="ms-2 small text-muted opacity-50">
                                            (Auto-escalates on SLA breach)
                                        </span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $wf->is_active ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }} px-3">
                                        <span class="status-dot {{ $wf->is_active ? 'bg-success' : 'bg-danger' }}"></span>
                                        {{ $wf->is_active ? 'Active' : 'Draft' }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded">
                                        <a href="{{ route('admin.master.workflows.show', $wf->id) }}" 
                                           class="btn btn-white btn-sm border" title="View Full Track">
                                            <i class="bi bi-eye color-primary"></i>
                                        </a>
                                        
                                        <a href="{{ route('admin.master.workflows.edit', $wf->id) }}" 
                                           class="btn btn-white btn-sm border" title="Modify Railroad">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </a>

                                        <button type="button" 
                                                class="btn btn-white btn-sm border text-danger" 
                                                title="Delete Track"
                                                onclick="confirmDelete('{{ $wf->id }}')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>

                                    {{-- Hidden Delete Form --}}
                                    <form id="delete-form-{{ $wf->id }}" 
                                          action="{{ route('admin.master.workflows.destroy', $wf->id) }}" 
                                          method="POST" style="display: none;">
                                        @csrf 
                                        @method('DELETE')
                                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() { 
            $('#workflow-table').DataTable({
                responsive: true,
                order: [[0, 'asc']],
                dom: '<"d-flex justify-content-between align-items-center p-3"<"small"l><"small"f>>rt<"d-flex justify-content-between align-items-center p-3"<"small"i><"small"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search tracks...",
                    lengthMenu: "_MENU_ per page",
                }
            }); 
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Workflows cannot be deleted if they are linked to active complaints.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endpush