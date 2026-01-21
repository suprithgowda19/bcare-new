@extends('layouts.admin')

@section('title', 'News')
@section('page_title', 'News Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">News</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">All News</h4>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Post News
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="news-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl.No</th>

                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newsItems as $index => $news)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>{{ Str::limit($news->title, 40) }}</td>
                                 <td>
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="news"
                                        style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                </td>
                                <td>
                                    <span class="badge {{ $news->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($news->status) }}
                                    </span>
                                </td>
                               
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.news.edit', $news->id) }}"
                                            class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this article?')">
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
            $('#news-table').DataTable();
        });
    </script>
@endpush
