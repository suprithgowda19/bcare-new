@extends('layouts.admin')

@section('title', 'Edit Activity')
@section('page_title', 'Update Activity')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">Activities</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Activity Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $activity->title) }}">
                        @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content/Description <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $activity->content) }}</textarea>
                        @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $activity->image) }}" class="img-thumbnail" width="100">
                            </div>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $activity->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $activity->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary">Update Activity</button>
                        <a href="{{ route('admin.activities.index') }}" class="btn btn-light">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection