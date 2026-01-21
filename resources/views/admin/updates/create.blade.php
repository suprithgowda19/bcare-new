@extends('layouts.admin')

@section('title', 'Add Update')
@section('page_title', 'Create New Update')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.updates.index') }}">Updates</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.updates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Update Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter title">
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tag Name (e.g. New, Event)</label>
                            <input type="text" name="tag_name" class="form-control @error('tag_name') is-invalid @enderror" value="{{ old('tag_name') }}" placeholder="Tag">
                            @error('tag_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short About/Summary</label>
                        <textarea name="about" class="form-control @error('about') is-invalid @enderror" rows="2" placeholder="Brief summary...">{{ old('about') }}</textarea>
                        @error('about') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Main Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="Full details...">{{ old('content') }}</textarea>
                        @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary">Save Update</button>
                        <a href="{{ route('admin.updates.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection