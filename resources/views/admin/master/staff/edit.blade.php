@extends('layouts.admin')

@section('title', 'Edit Staff')
@section('page_title', 'Edit Staff')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Edit Staff</li>
@endsection

@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }

    .card-body {
        padding: 32px;
    }

    .form-section {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 28px;
    }

    .form-section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 18px;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
    }

    .required-star {
        color: #ef4444;
        margin-left: 3px;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border-radius: 8px;
    }

    .select2-container--default .select2-selection--single {
        height: 44px;
        border-radius: 8px;
        padding: 6px 10px;
    }

    .select2-selection--multiple {
        min-height: 44px;
        border-radius: 8px;
    }

    .loading-spinner {
        display: none;
        margin-left: 6px;
        color: #6366f1;
        font-size: 0.85rem;
    }

    .btn-primary {
        padding: 10px 26px;
        border-radius: 8px;
    }

    .btn-light {
        padding: 10px 26px;
        border-radius: 8px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.master.staff.update', $staff->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- ================= BASIC INFO ================= --}}
                    <div class="form-section">
                        <div class="form-section-title">Basic Information</div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="required-star">*</span></label>
                                <input class="form-control" name="name" value="{{ old('name', $staff->name) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="required-star">*</span></label>
                                <input class="form-control" name="phone" value="{{ old('phone', $staff->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email <span class="required-star">*</span></label>
                                <input class="form-control" name="email" value="{{ old('email', $staff->email) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                            </div>
                        </div>
                    </div>

                    {{-- ================= CATEGORY ================= --}}
                    <div class="form-section">
                        <div class="form-section-title">Category Assignment</div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Category <span class="required-star">*</span></label>
                                <select id="category" name="category_id" class="form-select select2">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $staff->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Sub Category
                                    <span id="subcat-loader" class="loading-spinner">Loading…</span>
                                </label>
                                <select id="subcategory" name="sub_category_id" class="form-select select2">
                                    <option value="">Optional</option>
                                    @foreach($subCategories as $sub)
                                        <option value="{{ $sub->id }}" {{ $staff->sub_category_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ================= LOCATION ================= --}}
                    <div class="form-section">
                        <div class="form-section-title">Geographic Assignment</div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Corporation <span class="required-star">*</span></label>
                                <select id="corporation" class="form-select select2">
                                    <option value="">Select</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}" {{ $staff->corporation_id == $corp->id ? 'selected' : '' }}>
                                            {{ $corp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Zone <span class="required-star">*</span>
                                    <span id="zone-loader" class="loading-spinner">Loading…</span>
                                </label>
                                <select id="zone" class="form-select select2">
                                    <option value="">Select</option>
                                    @foreach($zones as $z)
                                        <option value="{{ $z->id }}" {{ $staff->zone_id == $z->id ? 'selected' : '' }}>
                                            {{ $z->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Constituency <span class="required-star">*</span>
                                    <span id="const-loader" class="loading-spinner">Loading…</span>
                                </label>
                                <select id="constituency" class="form-select select2">
                                    <option value="">Select</option>
                                    @foreach($constituencies as $c)
                                        <option value="{{ $c->id }}" {{ $staff->constituency_id == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Assigned Wards <span class="required-star">*</span>
                                    <span id="ward-loader" class="loading-spinner">Loading…</span>
                                </label>
                                <select id="wards" name="wards[]" class="form-select select2" multiple>
                                    @foreach($availableWards as $w)
                                        <option value="{{ $w->id }}" {{ in_array($w->id, $assignedWards) ? 'selected' : '' }}>
                                            {{ $w->number }} : {{ $w->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ================= ACTIONS ================= --}}
                    <div class="d-flex justify-content-end gap-3">
                        <button class="btn btn-primary">Update Staff</button>
                        <a href="{{ route('admin.master.staff.index') }}" class="btn btn-light">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
});

$(function () {
    $('.select2').select2({ width: '100%' });

    function resetSelect(id, placeholder = 'Select') {
        $('#' + id).empty().append(`<option value="">${placeholder}</option>`).trigger('change');
    }

    // Category → SubCategory
    $('#category').change(function () {
        resetSelect('subcategory');
        if (!this.value) return;
        $('#subcat-loader').show();
        $.get("{{ route('admin.master.get-sub-categories') }}", { category_id: this.value })
            .done(res => res.forEach(s => $('#subcategory').append(`<option value="${s.id}">${s.name}</option>`)))
            .always(() => $('#subcat-loader').hide());
    });

    // Corporation → Zone
    $('#corporation').change(function () {
        resetSelect('zone'); resetSelect('constituency'); resetSelect('wards');
        if (!this.value) return;
        $('#zone-loader').show();
        $.get("{{ route('admin.master.get-zones') }}", { corporation_id: this.value })
            .done(res => res.forEach(z => $('#zone').append(`<option value="${z.id}">${z.name}</option>`)))
            .always(() => $('#zone-loader').hide());
    });

    // Zone → Constituency
    $('#zone').change(function () {
        resetSelect('constituency'); resetSelect('wards');
        if (!this.value) return;
        $('#const-loader').show();
        $.get("{{ route('admin.master.get-constituencies') }}", { zone_id: this.value })
            .done(res => res.forEach(c => $('#constituency').append(`<option value="${c.id}">${c.name}</option>`)))
            .always(() => $('#const-loader').hide());
    });

    // Constituency → Wards
    $('#constituency').change(function () {
        resetSelect('wards');
        if (!this.value) return;
        $('#ward-loader').show();
        $.get("{{ route('admin.master.get-wards') }}", { constituency_id: this.value })
            .done(res => res.forEach(w => $('#wards').append(`<option value="${w.id}">${w.number} : ${w.name}</option>`)))
            .always(() => $('#ward-loader').hide());
    });
});
</script>
@endpush
