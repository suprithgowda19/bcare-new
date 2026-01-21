@extends('layouts.admin')

@section('title', 'Edit Content')
@section('page_title', 'Update Content Block')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.content.index') }}">Content</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.content.update', $content->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $content->title) }}">
                        @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Body Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="8">{{ old('content', $content->content) }}</textarea>
                        @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $content->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $content->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <button type="submit" class="btn btn-primary">Update Content</button>
                        <a href="{{ route('admin.content.index') }}" class="btn btn-light">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection