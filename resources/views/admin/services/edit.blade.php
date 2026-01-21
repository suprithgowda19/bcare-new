@extends('layouts.admin')

@section('title', 'Edit Service')
@section('page_title', 'Edit Service')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Service Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title) }}">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="4">{{ old('content', $service->content) }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="mt-2" style="width: 100px; border-radius: 5px;">
                        @endif
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Service</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection