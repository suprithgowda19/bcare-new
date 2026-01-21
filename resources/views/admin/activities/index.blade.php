@extends('layouts.admin')

@section('title', 'Activities')
@section('page_title', 'Activities Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Activities</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .activity-thumbnail {
            transition: transform 0.2s ease-in-out;
            border: 1px solid #ddd;
        }
        .activity-thumbnail:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Activity List</h4>
        <a href="{{ route('admin.activities.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Activity
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="activities-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.activities.show', $activity->id) }}" title="View Details">
                                        <img src="{{ asset('storage/' . $activity->image) }}" 
                                             alt="activity" 
                                             class="activity-thumbnail"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    </a>
                                </td>
                                <td>{{ $activity->title }}</td>
                                <td>
                                    <span class="badge {{ $activity->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.activities.show', $activity->id) }}" class="btn btn-sm btn-info me-2 text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.activities.edit', $activity->id) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Delete this activity?')">
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
            $('#activities-table').DataTable({
                pageLength: 10,
                ordering: true
            });
        });
    </script>
@endpush