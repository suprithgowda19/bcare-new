@extends('layouts.admin')

@section('title', 'Schemes')
@section('page_title', 'Schemes & Statistics')

@section('breadcrumb')
    <li class="breadcrumb-item active">Schemes</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .scheme-thumbnail {
            transition: transform 0.2s ease-in-out;
            border: 1px solid #ddd;
            padding: 4px;
            background: #fdfdfd;
            width: 50px; 
            height: 50px; 
            object-fit: contain; 
            border-radius: 4px;
        }
        .scheme-thumbnail:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .content-link { 
            text-decoration: none; 
            color: inherit; 
            transition: color 0.2s; 
        }
        .content-link:hover { 
            color: #5c61f2; 
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Scheme List</h4>
        <a href="{{ route('admin.schemes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Scheme
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="schemes-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Icon / Media</th>
                            <th>Scheme Title</th>
                            <th>Count</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schemes as $index => $scheme)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($scheme->image)
                                        <a href="{{ route('admin.schemes.show', $scheme->id) }}" title="View Details">
                                            <img src="{{ Storage::url($scheme->image) }}" 
                                                 alt="{{ $scheme->title }}" 
                                                 class="scheme-thumbnail">
                                        </a>
                                    @else
                                        <div class="bg-light text-center rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.schemes.show', $scheme->id) }}" class="content-link fw-bold">
                                        {{ $scheme->title }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-light-primary text-primary" style="font-size: 14px; font-weight: 600;">
                                        {{ number_format($scheme->count) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $scheme->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($scheme->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.schemes.show', $scheme->id) }}" class="btn btn-sm btn-info me-2 text-white" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.schemes.edit', $scheme->id) }}" class="btn btn-sm btn-primary me-2" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.schemes.destroy', $scheme->id) }}" method="POST" onsubmit="return confirm('Delete this scheme?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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
            $('#schemes-table').DataTable({
                pageLength: 10,
                ordering: true,
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search schemes..."
                },
                columnDefs: [
                    { orderable: false, targets: [1, 5] } // Disable ordering on Image and Actions
                ]
            });
        });
    </script>
@endpush