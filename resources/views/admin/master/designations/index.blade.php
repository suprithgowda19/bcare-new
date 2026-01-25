@extends('layouts.admin')

@section('title', 'Manage Designations')
@section('page_title', 'Designation Master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-bold">Departmental Roles</h6>
                    <small class="text-muted">Master list of roles mapped to categories for ticket routing.</small>
                </div>
                <a href="{{ route('admin.master.designations.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Add Designation
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-top" id="designationTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">Sl.No</th>
                                <th>Designation Name</th>
                                <th>Department (Category)</th>
                                <th>Specialization (Sub-Category)</th>
                                <th class="text-center">Staff Assigned</th>
                                <th class="text-center" width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($designations as $index => $designation)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="fw-bold d-block">{{ $designation->name }}</span>
                                        <small class="text-muted">ID: #{{ str_pad($designation->id, 4, '0', STR_PAD_LEFT) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-info text-info border">
                                            {{ $designation->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($designation->subcategory)
                                            <span class="badge bg-soft-secondary text-secondary border">
                                                {{ $designation->subcategory->name }}
                                            </span>
                                        @else
                                            <span class="text-muted small italic">General (Category Wide)</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill {{ $designation->users_count > 0 ? 'bg-primary' : 'bg-light text-dark' }}">
                                            {{ $designation->users_count }} Staff
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{ route('admin.master.designations.edit', $designation->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteDesignation({{ $designation->id }})"
                                                    title="Delete">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $designation->id }}" 
                                              action="{{ route('admin.master.designations.destroy', $designation->id) }}" 
                                              method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        No designations found. <a href="{{ route('admin.master.designations.create') }}">Create the first role.</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteDesignation(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently remove this role from the system!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Initialize DataTables if available
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#designationTable').DataTable({
                "pageLength": 10,
                "order": [[0, "asc"]],
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search roles..."
                }
            });
        }
    });
</script>
@endpush