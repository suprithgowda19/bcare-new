@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page_title', 'Update Category')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.master.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Name (English) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name (Kannada) <span class="text-danger">*</span></label>
                        <input type="text" name="name_kn" class="form-control @error('name_kn') is-invalid @enderror" value="{{ old('name_kn', $category->name_kn) }}">
                        @error('name_kn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="mt-2 rounded" style="width: 80px; border: 1px solid #ddd;">
                        @endif
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <a href="{{ route('admin.master.category.index') }}" class="btn btn-light">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection