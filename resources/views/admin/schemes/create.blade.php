@extends('layouts.admin')

@section('title', 'Create Scheme')
@section('page_title', 'Add New Scheme')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.schemes.index') }}">Schemes</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow-sm">
            <div class="card-header pb-0">
                <h5>Scheme Information</h5>
                <span>Please fill in the details below to add a new project or government scheme.</span>
            </div>
            <div class="card-body">
                <form class="theme-form" action="{{ route('admin.schemes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Title Field --}}
                    <div class="mb-3">
                        <label class="col-form-label pt-0">Scheme Title</label>
                        <input class="form-control @error('title') is-invalid @enderror" 
                               type="text" 
                               name="title" 
                               placeholder="e.g. Health Insurance / ಪಡಿತರ ಯೋಜನೆ" 
                               value="{{ old('title') }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Count Field --}}
                    <div class="mb-3">
                        <label class="col-form-label pt-0">Beneficiary Count / Total Limit</label>
                        <input class="form-control @error('count') is-invalid @enderror" 
                               type="number" 
                               name="count" 
                               value="{{ old('count', 0) }}" 
                               required>
                        @error('count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- File Upload Field (All Formats) --}}
                    <div class="mb-3">
                        <label class="col-form-label pt-0">Upload Icon or Featured Image</label>
                        <input class="form-control @error('image') is-invalid @enderror" 
                               type="file" 
                               name="image" 
                               accept="image/*,.svg" 
                               required>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Supported formats: <strong>SVG, PNG, JPG, JPEG, WEBP, GIF</strong> (Max: 2MB)
                            </small>
                        </div>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Field --}}
                    <div class="mb-3">
                        <label class="col-form-label pt-0">Display Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Show on PWA)</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive (Hide)</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="mt-4 mb-4">

                    {{-- Form Actions --}}
                    <div class="card-footer px-0 bg-transparent border-0">
                        <button type="submit" class="btn btn-primary btn-lg me-2">
                            <i class="bi bi-cloud-arrow-up me-1"></i> Save Scheme
                        </button>
                        <a href="{{ route('admin.schemes.index') }}" class="btn btn-light btn-lg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection