@extends('layouts.admin')

@section('title', 'Content Management')
@section('page_title', 'General Content')

@section('breadcrumb')
    <li class="breadcrumb-item active">Content</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .content-link { text-decoration: none; transition: color 0.2s; }
        .content-link:hover { color: #5c61f2; text-decoration: underline; }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Content Blocks</h4>
        <a href="{{ route('admin.content.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Content
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="content-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Title (Click to view)</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contents as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.content.show', $item->id) }}" class="content-link fw-bold">
                                        {{ $item->title }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge {{ $item->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('d M, Y') }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.content.show', $item->id) }}" class="btn btn-sm btn-info me-2 text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.content.edit', $item->id) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.content.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this content?')">
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
            $('#content-table').DataTable();
        });
    </script>
@endpush