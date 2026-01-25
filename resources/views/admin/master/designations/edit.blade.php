@extends('layouts.admin')

@section('title', 'Edit Designation')
@section('page_title', 'Update Designation')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.master.designations.update', $designation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Designation Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $designation->name) }}">
                        
                        {{-- INLINE ERROR MESSAGE --}}
                        @error('name') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Designation</button>
                    <a href="{{ route('admin.master.designations.index') }}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection