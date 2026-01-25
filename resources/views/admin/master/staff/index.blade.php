@extends('layouts.admin')

@section('title', 'Workforce Directory')
@section('page_title', 'Staff Management')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Staff</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .badge-ward {
            background-color: #f8f9fa;
            color: #6366f1;
            border: 1px solid #e0e7ff;
            border-radius: 6px;
            padding: 2px 10px;
            font-size: 0.7rem;
            margin: 2px;
            display: inline-block;
            font-weight: 700;
        }
        .staff-profile-title { font-size: 0.9rem; margin-bottom: 0; }
        .staff-contact { font-size: 0.75rem; color: #6c757d; }
        .table thead th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 font-700">Municipal Workforce</h4>
            <p class="text-muted small mb-0">Onboard and manage staff members assigned to departmental railroads.</p>
        </div>
        <a href="{{ route('admin.master.staff.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Add Staff Member
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="staff-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="ps-4">Sl.No</th>
                            <th>Staff Member</th>
                            <th>Department & Role</th>
                            <th>Jurisdiction (Wards)</th>
                            <th class="text-center">Account Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $index => $staff)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                
                                {{-- Staff Identity --}}
                                <td>
                                    <p class="staff-profile-title fw-bold text-dark">{{ $staff->name }}</p>
                                    <span class="staff-contact">
                                        <i class="bi bi-phone me-1"></i>{{ $staff->phone }}
                                    </span>
                                </td>

                                {{-- Designation & Category --}}
                                <td>
                                    <div class="small fw-bold text-primary text-uppercase" style="font-size: 0.7rem;">
                                        {{ $staff->designation->category->name ?? 'Unassigned Dept' }}
                                    </div>
                                    <div class="text-dark small">
                                        {{ $staff->designation->name ?? 'No Designation' }}
                                    </div>
                                </td>

                                {{-- Assigned Wards --}}
                                <td>
                                    <div class="d-flex flex-wrap" style="max-width: 300px;">
                                        @forelse($staff->wards as $ward)
                                            <span class="badge-ward" title="{{ $ward->name }}">W-{{ $ward->number }}</span>
                                        @empty
                                            <span class="text-muted italic small opacity-50">No Wards Assigned</span>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- Account Status --}}
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $staff->status == 'active' ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }} px-3">
                                        {{ strtoupper($staff->status ?? 'ACTIVE') }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm shadow-sm rounded">
                                        <a href="{{ route('admin.master.staff.show', $staff->id) }}" 
                                           class="btn btn-white border" title="View Profile">
                                            <i class="bi bi-eye text-info"></i>
                                        </a>
                                        
                                        <a href="{{ route('admin.master.staff.edit', $staff->id) }}" 
                                           class="btn btn-white border" title="Edit Profile">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </a>

                                        <button type="button" 
                                                class="btn btn-white border text-danger" 
                                                onclick="confirmDelete('{{ $staff->id }}', '{{ $staff->name }}')"
                                                title="Remove Staff">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>

                                    {{-- Hidden Delete Form --}}
                                    <form id="delete-form-{{ $staff->id }}" 
                                          action="{{ route('admin.master.staff.destroy', $staff->id) }}" 
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
            $('#staff-table').DataTable({
                responsive: true,
                order: [[1, 'asc']],
                dom: '<"d-flex justify-content-between align-items-center p-3"<"small"l><"small"f>>rt<"d-flex justify-content-between align-items-center p-3"<"small"i><"small"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Filter staff by name or ward...",
                }
            }); 
        });

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Archive Staff Member?',
                text: `Removing ${name} will prevent them from accessing the staff portal. This cannot be undone if they have historical ticket assignments.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, remove member'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endpush