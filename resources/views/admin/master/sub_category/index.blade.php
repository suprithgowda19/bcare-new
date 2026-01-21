@extends('layouts.admin')

@section('title', 'Sub Categories')
@section('page_title', 'Master Sub-Categories')

@section('breadcrumb')
    <li class="breadcrumb-item active">Sub Categories</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Manage Sub Categories</h4>
        <a href="{{ route('admin.master.sub-category.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Sub Category
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="subcategory-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>English Name</th>
                            <th>Kannada Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subCategories as $index => $sub)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.master.sub-category.show', $sub->id) }}">
                                        <img src="{{ asset('storage/' . ($sub->image ?? 'no-image.png')) }}" 
                                             alt="sub" 
                                             class="img-thumbnail"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </a>
                                </td>
                                <td><span class="badge bg-light-primary text-primary">{{ $sub->category->name ?? 'Deleted' }}</span></td>
                                <td>{{ $sub->name }}</td>
                                <td>{{ $sub->name_kn }}</td>
                                <td>
                                    <span class="badge {{ $sub->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($sub->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.master.sub-category.show', $sub->id) }}" class="btn btn-sm btn-info text-white me-2"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.master.sub-category.edit', $sub->id) }}" class="btn btn-sm btn-primary me-2"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('admin.master.sub-category.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Delete this record permanently?')">
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
        $(document).ready(function() { $('#subcategory-table').DataTable(); });
    </script>
@endpush