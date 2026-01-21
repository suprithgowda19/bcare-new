@extends('layouts.admin')

@section('title', 'Edit Scheme')
@section('page_title', 'Update Scheme')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.schemes.index') }}">Schemes</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form class="theme-form" action="{{ route('admin.schemes.update', $scheme->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="col-form-label pt-0">Scheme Title</label>
                        <input class="form-control" type="text" name="title" value="{{ $scheme->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label pt-0">Beneficiary Count</label>
                        <input class="form-control" type="number" name="count" value="{{ $scheme->count }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label pt-0">Replace SVG Icon (Optional)</label>
                        <input class="form-control" type="file" name="image" accept=".svg">
                        <div class="mt-3">
                            <p class="mb-1 small">Current Icon:</p>
                            <img src="{{ Storage::url($scheme->image) }}" width="60" class="bg-light p-2 border">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label pt-0">Status</label>
                        <select class="form-select" name="status">
                            <option value="active" {{ $scheme->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $scheme->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Changes</button>
                        <a href="{{ route('admin.schemes.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection