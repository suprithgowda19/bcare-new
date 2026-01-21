@extends('layouts.admin')

@section('title', 'About Us')
@section('page_title', 'About Section Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">About</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
        .hover-img { transition: 0.3s; border: 1px solid #eee; }
        .hover-img:hover { transform: scale(1.1); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Entries</h4>
        <a href="{{ route('admin.about.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Section
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="about-table" style="width:100%">
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
                        @foreach ($abouts as $index => $about)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.about.show', $about->id) }}">
                                        <img src="{{ asset('storage/' . $about->image) }}" 
                                             alt="about" 
                                             class="hover-img"
                                             style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    </a>
                                </td>
                                <td>{{ Str::limit($about->title, 40) }}</td>
                                <td>
                                    <span class="badge {{ $about->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($about->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.about.show', $about->id) }}" class="btn btn-sm btn-info me-2 text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.about.edit', $about->id) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.about.destroy', $about->id) }}" method="POST" onsubmit="return confirm('Delete this section?')">
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
            $('#about-table').DataTable();
        });
    </script>
@endpush