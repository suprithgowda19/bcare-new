@extends('layouts.admin')

@section('title', 'Banners')
@section('page_title', 'Banners')

@section('breadcrumb')
    <li class="breadcrumb-item active">Banners</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .banner-img-link img {
            transition: transform 0.2s ease-in-out;
        }
        .banner-img-link img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Banner Management</h4>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Banner
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="banners-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Image (Click to view)</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banners as $index => $banner)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.banners.show', $banner->id) }}" class="banner-img-link">
                                        <img src="{{ asset('storage/' . $banner->image) }}" 
                                             alt="Banner" 
                                             style="width: 70px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                    </a>
                                </td>
                                <td>{{ $banner->title }}</td>
                                <td>
                                    <span class="badge {{ $banner->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $banner->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.banners.show', $banner->id) }}" class="btn btn-sm btn-info me-2 text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Delete this banner?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No banners found.</td>
                            </tr>
                        @endforelse
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
            $('#banners-table').DataTable({
                pageLength: 10,
                ordering: true
            });
        });
    </script>
@endpush