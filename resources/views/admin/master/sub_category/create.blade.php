@extends('layouts.admin')

@section('title', 'Add Sub Category')
@section('page_title', 'Create New Sub Category')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.master.sub-category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Parent Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">English Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kannada Name <span class="text-danger">*</span></label>
                        <input type="text" name="name_kn" class="form-control @error('name_kn') is-invalid @enderror" value="{{ old('name_kn') }}">
                        @error('name_kn') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">Save Sub Category</button>
                        <a href="{{ route('admin.master.sub-category.index') }}" class="btn btn-light">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection