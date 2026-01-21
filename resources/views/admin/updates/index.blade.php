@extends('layouts.admin')

@section('title', 'Updates')
@section('page_title', 'Updates Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Updates</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">All Updates</h4>
        <a href="{{ route('admin.updates.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Update
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="updates-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Tag</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($updates as $index => $update)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $update->image) }}" alt="img" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                </td>
                                <td>{{ Str::limit($update->title, 30) }}</td>
                                <td><span class="badge badge-light-primary">{{ $update->tag_name ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="badge {{ $update->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($update->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.updates.edit', $update->id) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.updates.destroy', $update->id) }}" method="POST" onsubmit="return confirm('Delete this update?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
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
        $(document).ready(function() {
            $('#updates-table').DataTable();
        });
    </script>
@endpush