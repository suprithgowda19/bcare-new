@extends('layouts.admin')

@section('title', 'Edit Staff Member')
@section('page_title', 'Edit Staff Profile')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.master.staff.index') }}">Staff</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/vendors/select2.css') }}">
<style>
    .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: none; }
    .form-label { font-weight: 600; color: #333; }
    .required { color: #dc3545; }
    .section-title { 
        border-bottom: 2px solid #f0f0f0; 
        padding-bottom: 10px; 
        margin-bottom: 20px; 
        color: #ff9f43; 
        font-size: 0.85rem; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        font-weight: 700;
    }
    /* Style for the multi-select box to ensure it looks modern */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6;
        min-height: 45px;
        border-radius: 8px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <form method="POST" action="{{ route('admin.master.staff.update', $staff->id) }}" id="staffForm">
            @csrf
            @method('PUT')

            <div class="card mb-4">
                <div class="card-body p-4">
                    {{-- 1. ACCOUNT INFORMATION --}}
                    <h6 class="section-title"><i class="bi bi-person-badge me-2"></i>Step 1: Identity & Credentials</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $staff->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Mobile Phone <span class="required">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $staff->phone) }}" required maxlength="10">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $staff->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Update Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Leave blank to keep current">
                            <small class="text-muted">Only fill this if you want to reset their password.</small>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- 2. DEPARTMENT & DESIGNATION --}}
                    <h6 class="section-title mt-4"><i class="bi bi-briefcase me-2"></i>Step 2: Departmental Assignment</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Department (Category) <span class="required">*</span></label>
                            <select id="category_id" name="category_id" class="form-select select2 @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $staff->designation->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sub-Category</label>
                            <select id="sub_category_id" name="sub_category_id" class="form-select select2">
                                <option value="">General / None</option>
                                {{-- Dynamically populated via JS --}}
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Designation <span class="required">*</span></label>
                            <select id="designation_id" name="designation_id" class="form-select select2 @error('designation_id') is-invalid @enderror" required>
                                <option value="">Select Category First</option>
                                {{-- Dynamically populated via JS --}}
                            </select>
                            @error('designation_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- 3. JURISDICTION --}}
                    <h6 class="section-title mt-4"><i class="bi bi-geo-alt me-2"></i>Step 3: Area Jurisdiction</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Search Geographic Filters</label>
                            <div class="mb-2">
                                <select id="corporation" class="form-select select2 mb-2">
                                    <option value="">Select Corporation</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}">{{ $corp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <select id="zone" class="form-select select2" disabled>
                                    <option value="">Select Zone</option>
                                </select>
                            </div>
                            <div>
                                <select id="constituency" class="form-select select2" disabled>
                                    <option value="">Select Constituency</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Assigned Wards <span class="required">*</span></label>
                            <select name="wards[]" id="wards" class="form-select select2 @error('wards') is-invalid @enderror" multiple required>
                                @foreach($staff->wards as $ward)
                                    <option value="{{ $ward->id }}" selected>Ward {{ $ward->number }} : {{ $ward->name }}</option>
                                @endforeach
                            </select>
                            @error('wards') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <div class="form-text mt-2 text-primary">
                                <i class="bi bi-info-circle me-1"></i> Current wards are pre-selected. Use the filters on the left to find and add more.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5 border-top pt-4">
                        <a href="{{ route('admin.master.staff.index') }}" class="btn btn-light px-4 me-2">Cancel</a>
                        <button type="submit" class="btn btn-warning px-5 shadow-sm text-white fw-bold">
                            <i class="bi bi-save me-2"></i>Update Staff Profile
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script>
$(function () {
    $('.select2').select2({ width: '100%' });

    // Initial state variables from Controller/Model
    const currentSubCatId = "{{ old('sub_category_id', $staff->designation->subcategory_id ?? '') }}";
    const currentDesignationId = "{{ old('designation_id', $staff->designation_id) }}";

    /**
     * AJAX: Fetch Designations
     */
    function fetchDesignations() {
        const catId = $('#category_id').val();
        const subCatId = $('#sub_category_id').val();
        const $desig = $('#designation_id');

        if (!catId) return;

        $.get("{{ route('admin.master.staff.get-eligible-designations') }}", { 
            category_id: catId, 
            sub_category_id: subCatId 
        }, function(res) {
            $desig.empty().append('<option value="">Select Designation</option>');
            res.forEach(d => {
                const isSelected = (d.id == currentDesignationId) ? 'selected' : '';
                $desig.append(`<option value="${d.id}" ${isSelected}>${d.name}</option>`);
            });
            $desig.trigger('change');
        });
    }

    /**
     * AJAX: Fetch Sub-Categories
     */
    function fetchSubCategories(selectedId = null) {
        const catId = $('#category_id').val();
        const $subCat = $('#sub_category_id');

        if (!catId) return;

        $.get("{{ route('admin.master.staff.get-subcategories') }}", { category_id: catId }, function(res) {
            $subCat.empty().append('<option value="">General / None</option>');
            res.forEach(s => {
                const isSelected = (s.id == currentSubCatId) ? 'selected' : '';
                $subCat.append(`<option value="${s.id}" ${isSelected}>${s.name}</option>`);
            });
            $subCat.trigger('change');
            fetchDesignations(); // Chain to designations
        });
    }

    // Trigger initial load on page ready
    fetchSubCategories();

    // Listeners for Step 2
    $('#category_id').change(() => fetchSubCategories());
    $('#sub_category_id').change(() => fetchDesignations());

    /**
     * GEOGRAPHIC CASCADES (Step 3)
     */
    [Image of cascading dropdown menus for geographic data selection]
    $('#corporation').change(function () {
        $('#zone, #constituency').prop('disabled', true).empty();
        if (!this.value) return;
        $.get("{{ route('admin.master.staff.get-zones') }}", { corporation_id: this.value }, res => {
            $('#zone').prop('disabled', false).append('<option value="">Select Zone</option>');
            res.forEach(z => $('#zone').append(`<option value="${z.id}">${z.name}</option>`));
        });
    });

    $('#zone').change(function () {
        $('#constituency').prop('disabled', true).empty();
        if (!this.value) return;
        $.get("{{ route('admin.master.staff.get-constituencies') }}", { zone_id: this.value }, res => {
            $('#constituency').prop('disabled', false).append('<option value="">Select Constituency</option>');
            res.forEach(c => $('#constituency').append(`<option value="${c.id}">${c.name}</option>`));
        });
    });

    $('#constituency').change(function () {
        if (!this.value) return;
        $.get("{{ route('admin.master.staff.get-wards') }}", { constituency_id: this.value }, res => {
            const $wardsSelect = $('#wards');
            res.forEach(w => {
                if ($(`#wards option[value='${w.id}']`).length === 0) {
                    $wardsSelect.append(new Option(`Ward ${w.number} : ${w.name}`, w.id, true, true));
                }
            });
            $wardsSelect.trigger('change');
        });
    });
});
</script>
@endpush