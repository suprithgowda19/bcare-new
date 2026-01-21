@extends('layouts.admin')

@section('title', 'Category Details')
@section('page_title', 'View Category')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Details: {{ $category->name }}</h5>
                <a href="{{ route('admin.master.category.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                    @else
                        <div class="bg-light p-5 rounded">No Image Available</div>
                    @endif
                </div>
                <table class="table table-bordered">
                    <tr><th>Name (English)</th><td>{{ $category->name }}</td></tr>
                    <tr><th>Name (Kannada)</th><td>{{ $category->name_kn }}</td></tr>
                    <tr><th>Status</th><td>
                        <span class="badge {{ $category->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($category->status) }}
                        </span>
                    </td></tr>
                    <tr><th>Created At</th><td>{{ $category->created_at->format('d M, Y h:i A') }}</td></tr>
                </table>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('admin.master.category.edit', $category->id) }}" class="btn btn-primary">Edit Category</a>
            </div>
        </div>
    </div>
</div>
@endsection