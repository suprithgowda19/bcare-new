@extends('layouts.admin')

@section('title', 'Add Staff Member')
@section('page_title', 'Staff Onboarding')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.master.staff.index') }}">Staff</a></li>
    <li class="breadcrumb-item active">Add Staff</li>
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
        color: #0d6efd; 
        font-size: 0.85rem; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        font-weight: 700;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        min-height: 45px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <form method="POST" action="{{ route('admin.master.staff.store') }}" id="staffForm">
            @csrf

            <div class="card mb-4 shadow-sm">
                <div class="card-body p-4">
                    {{-- 1. ACCOUNT INFORMATION --}}
                    <h6 class="section-title"><i class="bi bi-person-badge me-2"></i>Step 1: Identity & Credentials</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter full name" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Mobile Phone <span class="required">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="10-digit mobile number" required maxlength="10">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="official@email.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Temporary Password <span class="required">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 characters" required>
                            <small class="text-muted">Staff can change this after their first login.</small>
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
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sub-Category <small class="text-muted">(Optional)</small></label>
                            <select id="sub_category_id" name="sub_category_id" class="form-select select2">
                                <option value="">General / None</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Designation (Role) <span class="required">*</span></label>
                            <select id="designation_id" name="designation_id" class="form-select select2 @error('designation_id') is-invalid @enderror" required>
                                <option value="">Select Department First</option>
                            </select>
                            @error('designation_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- 3. JURISDICTION --}}
                    <h6 class="section-title mt-4"><i class="bi bi-geo-alt me-2"></i>Step 3: Area Jurisdiction</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Quick Search (Geographic Filter)</label>
                            <div class="input-group mb-2">
                                <select id="corporation" class="form-select select2">
                                    <option value="">Select Corp</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}">{{ $corp->name }}</option>
                                    @endforeach
                                </select>
                                <select id="zone" class="form-select select2" disabled>
                                    <option value="">Select Zone</option>
                                </select>
                            </div>
                            <select id="constituency" class="form-select select2" disabled>
                                <option value="">Select Constituency</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Assigned Wards <span class="required">*</span></label>
                            <select name="wards[]" id="wards" class="form-select select2 @error('wards') is-invalid @enderror" multiple required data-placeholder="Assign specific wards to this staff member">
                            </select>
                            @error('wards') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <div class="form-text mt-2 text-info">
                                <i class="bi bi-info-circle me-1"></i> Use the filters on the left to automatically add wards to this list. You can remove them by clicking the 'x'.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5 border-top pt-4">
                        <a href="{{ route('admin.master.staff.index') }}" class="btn btn-light px-4 me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>Onboard Staff Member
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

    /**
     * 1. DESIGNATION LOGIC (Category -> SubCategory -> Designation)
     */
    function fetchDesignations() {
        const catId = $('#category_id').val();
        const subCatId = $('#sub_category_id').val();
        const $desig = $('#designation_id');

        if (!catId) {
            $desig.empty().append('<option value="">Select Category First</option>');
            return;
        }

        $.get("{{ route('admin.master.staff.get-eligible-designations') }}", { 
            category_id: catId, 
            sub_category_id: subCatId 
        }, function(res) {
            $desig.empty().append('<option value="">Select Designation</option>');
            res.forEach(d => $desig.append(`<option value="${d.id}">${d.name}</option>`));
            $desig.trigger('change');
        });
    }

    $('#category_id').change(function () {
        const catId = $(this).val();
        const $subCat = $('#sub_category_id');
        $subCat.empty().append('<option value="">General / None</option>');
        
        if (catId) {
            $.get("{{ route('admin.master.staff.get-subcategories') }}", { category_id: catId }, function(res) {
                res.forEach(s => $subCat.append(`<option value="${s.id}">${s.name}</option>`));
                $subCat.trigger('change');
            });
        }
        fetchDesignations();
    });

    $('#sub_category_id').change(fetchDesignations);

    /**
     * 2. GEOGRAPHIC CASCADE (Search for Wards)
     */
    
    $('#corporation').change(function () {
        $('#zone, #constituency').prop('disabled', true).empty();
        if (!this.value) return;
        $.get("{{ route('admin.master.staff.get-zones') }}", { corporation_id: this.value }, res => {
            $('#zone').prop('disabled', false).append('<option value="">Select Zone</option>').trigger('change');
            res.forEach(z => $('#zone').append(`<option value="${z.id}">${z.name}</option>`));
        });
    });

    $('#zone').change(function () {
        $('#constituency').prop('disabled', true).empty();
        if (!this.value) return;
        $.get("{{ route('admin.master.staff.get-constituencies') }}", { zone_id: this.value }, res => {
            $('#constituency').prop('disabled', false).append('<option value="">Select Constituency</option>').trigger('change');
            res.forEach(c => $('#constituency').append(`<option value="${c.id}">${c.name}</option>`));
        });
    });

    // When Constituency is selected, push all its Wards into the Assignment box
    $('#constituency').change(function () {
        if (!this.value) return;
        $.get("{{ route('admin.master.staff.get-wards') }}", { constituency_id: this.value }, res => {
            const $wardsSelect = $('#wards');
            const currentSelected = $wardsSelect.val() || [];
            
            res.forEach(w => {
                // If ward isn't in dropdown, add it
                if ($(`#wards option[value='${w.id}']`).length === 0) {
                    $wardsSelect.append(new Option(`Ward ${w.number} : ${w.name}`, w.id, true, true));
                } else {
                    // If it is in dropdown but not selected, select it
                    if (!currentSelected.includes(w.id.toString())) {
                        currentSelected.push(w.id.toString());
                        $wardsSelect.val(currentSelected).trigger('change');
                    }
                }
            });
            $wardsSelect.trigger('change');
        });
    });
});
</script>
@endpush