@extends('layouts.admin')

@section('title', 'Public Users')
@section('page_title', 'Registered Public Users')

@section('breadcrumb')
    <li class="breadcrumb-item active">Public Users</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Public Users List</h4>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="display" id="public-users-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Registered On</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->phone }}</td>

                            <td>{{ $user->email ?? '-' }}</td>

                            <td>
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>

                            <td>{{ $user->created_at->format('d M Y') }}</td>

                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.master.public.show', $user->id) }}"
                                       class="btn btn-sm btn-info me-2 text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
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
            $('#public-users-table').DataTable({
                pageLength: 10,
                ordering: true,
                order: [[5, 'desc']], // Registered On
            });
        });
    </script>
@endpush
