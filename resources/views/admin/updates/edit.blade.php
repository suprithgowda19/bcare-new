@extends('layouts.admin')

@section('title', 'Edit Update')
@section('page_title', 'Update Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.updates.index') }}">Updates</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.updates.update', $update->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Update Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $update->title) }}">
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tag Name</label>
                            <input type="text" name="tag_name" class="form-control @error('tag_name') is-invalid @enderror" value="{{ old('tag_name', $update->tag_name) }}">
                            @error('tag_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Summary</label>
                        <textarea name="about" class="form-control @error('about') is-invalid @enderror" rows="2">{{ old('about', $update->about) }}</textarea>
                        @error('about') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Main Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $update->content) }}</textarea>
                        @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $update->image) }}" class="img-thumbnail" width="100">
                            </div>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $update->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $update->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary">Update Details</button>
                        <a href="{{ route('admin.updates.index') }}" class="btn btn-light">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection