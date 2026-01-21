@extends('layouts.admin')

@section('title', 'Categories')
@section('page_title', 'Master Categories')

@section('breadcrumb')
    <li class="breadcrumb-item active">Categories</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .cat-thumb { transition: 0.3s; cursor: pointer; border: 1px solid #eee; }
        .cat-thumb:hover { transform: scale(1.1); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Category List</h4>
        <a href="{{ route('admin.master.category.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Category
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="category-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Image</th>
                            <th>Name (English)</th>
                            <th>Name (Kannada)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.master.category.show', $category->id) }}">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="" class="cat-thumb" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </a>
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->name_kn }}</td>
                                <td>
                                    <span class="badge {{ $category->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($category->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.master.category.show', $category->id) }}" class="btn btn-sm btn-info me-2 text-white"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.master.category.edit', $category->id) }}" class="btn btn-sm btn-primary me-2"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('admin.master.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
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
        $(document).ready(function() { $('#category-table').DataTable(); });
    </script>
@endpush