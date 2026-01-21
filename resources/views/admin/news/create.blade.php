@extends('layouts.admin')

@section('title', 'Post News')
@section('page_title', 'Create News Article')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Title  <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter news title">
                        @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">About</label>
                        <input type="text" name="about" class="form-control @error('about') is-invalid @enderror" value="{{ old('about') }}" placeholder="Short intro text">
                        @error('about') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="6" placeholder="Write the full article here...">{{ old('content') }}</textarea>
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
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Publish)</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
                            </select>
                            @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <button type="submit" class="btn btn-primary">Publish News</button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection