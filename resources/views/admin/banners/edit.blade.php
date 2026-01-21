@extends('layouts.admin')

@section('title', 'Edit Banner')
@section('page_title', 'Update Banner')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $banner->title) }}">
                        @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content/Description</label>
                        <textarea name="content" 
                                  class="form-control @error('content') is-invalid @enderror" 
                                  rows="3">{{ old('content', $banner->content) }}</textarea>
                        @error('content')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Banner Image</label>
                        <input type="file" name="image" 
                               class="form-control @error('image') is-invalid @enderror">
                        <div class="mt-2">
                            <p class="mb-1 small">Current Image:</p>
                            <img src="{{ asset('storage/'.$banner->image) }}" class="img-thumbnail" width="150">
                        </div>
                        @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="bannerStatus" {{ old('status', $banner->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="bannerStatus">Active</label>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <button type="submit" class="btn btn-primary">Update Banner</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection