@extends('layouts.admin')

@section('title', 'Services')
@section('page_title', 'Services Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Services</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .service-img-link img {
            transition: transform 0.2s ease-in-out;
        }
        .service-img-link img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Service List</h4>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Service
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="services-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Image</th>
                            <th>Service Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $index => $service)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($service->image)
                                        <a href="{{ route('admin.services.show', $service->id) }}" class="service-img-link">
                                            <img src="{{ asset('storage/' . $service->image) }}" 
                                                 alt="{{ $service->title }}" 
                                                 style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        </a>
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $service->title }}</td>
                                <td>
                                    <span class="badge {{ $service->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.services.show', $service->id) }}" class="btn btn-sm btn-info me-2 text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Delete this service?')">
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
            $('#services-table').DataTable({
                pageLength: 10,
                ordering: true
            });
        });
    </script>
@endpush