@extends('layouts.admin')

@section('title', 'Staff')
@section('page_title', 'Staff Management')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Staff</li>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<style>
    .badge-ward {
        background-color: #f0f2f5;
        color: #0d6efd;
        border: 1px solid #dcdfe6;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 0.75rem;
        margin: 2px;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Staff List</h4>


        <a href="{{ route('admin.master.staff.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Staff
        </a>
    
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="display" id="staff-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Staff</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Assigned Wards</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staffs as $index => $staff)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <strong>{{ $staff->name }}</strong><br>
                                <small class="text-muted">{{ $staff->phone }}</small>
                            </td>

                            <td>{{ $staff->category->name ?? '-' }}</td>

                            <td>{{ $staff->subCategory->name ?? '—' }}</td>

                            <td>
                                @forelse($staff->wards as $ward)
                                    <span class="badge-ward">
                                        {{ $ward->number }} - {{ $ward->name }}
                                    </span>
                                @empty
                                    <span class="text-muted small">No wards</span>
                                @endforelse
                            </td>

                            <td>
                                <span class="badge {{ $staff->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.master.staff.show', $staff->id) }}"
                                       class="btn btn-sm btn-info text-white"
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.master.staff.edit', $staff->id) }}"
                                       class="btn btn-sm btn-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.master.staff.destroy', $staff->id) }}"
                                          onsubmit="return confirm('Delete this staff member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
<script>
$(document).ready(function () {
    $('#staff-table').DataTable({
        pageLength: 10,
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search staff..."
        }
    });
});
</script>
@endpush
