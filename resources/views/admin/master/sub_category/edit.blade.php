@extends('layouts.admin')

@section('title', 'Edit Sub Category')
@section('page_title', 'Update Sub Category Details')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.master.sub-category.update', $subCategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Parent Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $subCategory->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">English Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $subCategory->name) }}">
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kannada Name <span class="text-danger">*</span></label>
                        <input type="text" name="name_kn" class="form-control @error('name_kn') is-invalid @enderror" value="{{ old('name_kn', $subCategory->name_kn) }}">
                        @error('name_kn') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @if($subCategory->image)
                            <img src="{{ asset('storage/' . $subCategory->image) }}" class="mt-2 rounded" style="width: 80px; border: 1px solid #ddd;">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $subCategory->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $subCategory->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <button type="submit" class="btn btn-primary">Update Details</button>
                        <a href="{{ route('admin.master.sub-category.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection