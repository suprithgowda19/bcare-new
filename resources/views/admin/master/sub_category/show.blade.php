@extends('layouts.admin')

@section('title', 'Sub Category Details')
@section('page_title', 'View Sub Category')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between border-bottom">
                <h5 class="mb-0 text-primary">Details: {{ $subCategory->name }}</h5>
                <a href="{{ route('admin.master.sub-category.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
            <div class="card-body">
                <div class="text-center mb-4 bg-light p-3 rounded">
                    @if($subCategory->image)
                        <img src="{{ asset('storage/' . $subCategory->image) }}" class="img-fluid rounded border shadow-sm" style="max-height: 250px;">
                    @else
                        <div class="text-muted p-5">No Image Uploaded</div>
                    @endif
                </div>
                <table class="table table-striped table-bordered">
                    <tr><th class="bg-light">Category</th><td>{{ $subCategory->category->name ?? 'N/A' }}</td></tr>
                    <tr><th class="bg-light">Name (English)</th><td>{{ $subCategory->name }}</td></tr>
                    <tr><th class="bg-light">Name (Kannada)</th><td>{{ $subCategory->name_kn }}</td></tr>
                    <tr><th class="bg-light">Status</th><td>
                        <span class="badge {{ $subCategory->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($subCategory->status) }}
                        </span>
                    </td></tr>
                </table>
            </div>
            <div class="card-footer bg-light text-end">
                <a href="{{ route('admin.master.sub-category.edit', $subCategory->id) }}" class="btn btn-primary">Edit Entry</a>
            </div>
        </div>
    </div>
</div>
@endsection