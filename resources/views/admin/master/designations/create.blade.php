@extends('layouts.admin')

@section('title', 'Add Departmental Designation')
@section('page_title', 'Create Designation')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Role Details</h6>
                <small class="text-muted">Link this designation to a specific department for accurate routing.</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.master.designations.store') }}" method="POST" id="designationForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Department (Category) <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select Department --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Specialization (Sub-Category) <small class="text-muted">(Optional)</small></label>
                        <select name="subcategory_id" id="subcategory_id" class="form-select @error('subcategory_id') is-invalid @enderror">
                            <option value="">-- General (No Sub-Category) --</option>
                            {{-- Populated via AJAX --}}
                        </select>
                        @error('subcategory_id') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label fw-bold">Designation Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="e.g. Junior Engineer" 
                               value="{{ old('name') }}" required>
                        @error('name') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.master.designations.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Designation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Cascading logic: Category -> SubCategory
    $('#category_id').on('change', function() {
        const categoryId = $(this).val();
        const $subCategorySelect = $('#subcategory_id');
        
        // Reset sub-category dropdown
        $subCategorySelect.empty().append('<option value="">-- General (No Sub-Category) --</option>');
        
        if (categoryId) {
            // Fetch subcategories via AJAX
            $.get("{{ route('admin.master.designations.get-subcategories') }}", { category_id: categoryId }, function(data) {
                $.each(data, function(index, sub) {
                    $subCategorySelect.append('<option value="' + sub.id + '">' + sub.name + '</option>');
                });
            });
        }
    });

    // Handle old value for subcategory after validation failure
    @if(old('category_id') && old('subcategory_id'))
        const oldCatId = "{{ old('category_id') }}";
        const oldSubId = "{{ old('subcategory_id') }}";
        
        $.get("{{ route('admin.master.designations.get-subcategories') }}", { category_id: oldCatId }, function(data) {
            const $subCategorySelect = $('#subcategory_id');
            $.each(data, function(index, sub) {
                const selected = (sub.id == oldSubId) ? 'selected' : '';
                $subCategorySelect.append('<option value="' + sub.id + '" ' + selected + '>' + sub.name + '</option>');
            });
        });
    @endif
});
</script>
@endpush