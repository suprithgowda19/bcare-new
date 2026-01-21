@extends('layouts.admin')

@section('title', 'Add Staff')
@section('page_title', 'Add Staff')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Add Staff</li>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/vendors/select2.css') }}">
<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: none;
    }
    .form-label {
        font-weight: 600;
    }
    .required {
        color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.master.staff.store') }}">
                    @csrf

                    {{-- BASIC INFO --}}
                    <h6 class="mb-3 text-muted">Basic Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="required">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="required">*</span></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>

                    <hr>

                    {{-- WORK ALLOCATION --}}
                    <h6 class="mb-3 text-muted">Work Allocation</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Corporation <span class="required">*</span></label>
                            <select id="corporation" class="form-select select2">
                                <option value="">Select</option>
                                @foreach($corporations as $corp)
                                    <option value="{{ $corp->id }}">{{ $corp->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Zone <span class="required">*</span></label>
                            <select id="zone" class="form-select select2" disabled></select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Constituency <span class="required">*</span></label>
                            <select id="constituency" class="form-select select2" disabled></select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Wards <span class="required">*</span></label>
                            <select name="wards[]" id="wards" class="form-select select2" multiple disabled></select>
                        </div>
                    </div>

                    <hr>

                    {{-- CATEGORY --}}
                    <h6 class="mb-3 text-muted">Category Assignment</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="required">*</span></label>
                            <select id="category" name="category_id" class="form-select select2">
                                <option value="">Select</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sub Category</label>
                            <select id="subcategory" name="sub_category_id" class="form-select select2">
                                <option value="">Optional</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.master.staff.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            Create Staff
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script>
$(function () {
    $('.select2').select2({ width: '100%' });

    // Category → SubCategory
    $('#category').change(function () {
        $('#subcategory').empty().append('<option value="">Optional</option>');
        if (!this.value) return;

        $.get("{{ route('admin.master.get-sub-categories') }}", {
            category_id: this.value
        }, res => {
            res.forEach(s => {
                $('#subcategory').append(`<option value="${s.id}">${s.name}</option>`);
            });
        });
    });

    // Corporation → Zone
    $('#corporation').change(function () {
        $('#zone').prop('disabled', true).empty();
        $('#constituency').prop('disabled', true).empty();
        $('#wards').prop('disabled', true).empty();

        if (!this.value) return;

        $.get("{{ route('admin.master.get-zones') }}", {
            corporation_id: this.value
        }, res => {
            $('#zone').prop('disabled', false).append('<option value="">Select</option>');
            res.forEach(z => $('#zone').append(`<option value="${z.id}">${z.name}</option>`));
        });
    });

    // Zone → Constituency
    $('#zone').change(function () {
        $('#constituency').prop('disabled', true).empty();
        $('#wards').prop('disabled', true).empty();

        if (!this.value) return;

        $.get("{{ route('admin.master.get-constituencies') }}", {
            zone_id: this.value
        }, res => {
            $('#constituency').prop('disabled', false).append('<option value="">Select</option>');
            res.forEach(c => $('#constituency').append(`<option value="${c.id}">${c.name}</option>`));
        });
    });

    // Constituency → Wards
    $('#constituency').change(function () {
        $('#wards').prop('disabled', true).empty();

        if (!this.value) return;

        $.get("{{ route('admin.master.get-wards') }}", {
            constituency_id: this.value
        }, res => {
            $('#wards').prop('disabled', false);
            res.forEach(w => {
                $('#wards').append(`<option value="${w.id}">${w.number} : ${w.name}</option>`);
            });
        });
    });
});
</script>
@endpush
