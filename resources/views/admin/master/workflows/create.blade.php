@extends('layouts.admin')

@section('title', 'Create Workflow')
@section('page_title', 'Escalation Railroad Builder')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .card { border-radius: 15px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .step-card { border-left: 5px solid #6366f1; background: #f8f9ff; margin-bottom: 20px; transition: all 0.2s; }
    .step-card:hover { transform: translateX(5px); }
    .step-number { width: 35px; height: 35px; background: #6366f1; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .section-title { font-size: 0.8rem; font-weight: 700; color: #8898aa; text-transform: uppercase; letter-spacing: 1px; }
    .btn-indigo { background-color: #6366f1; color: white; }
    .btn-indigo:hover { background-color: #4f46e5; color: white; }
    .total-sla-badge { background: #eef2ff; color: #6366f1; border: 1px solid #e0e7ff; padding: 10px 20px; border-radius: 10px; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            {{-- Validation Errors --}}
            @if(session('error'))
                <div class="alert alert-danger mb-4 shadow-sm border-0">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.master.workflows.store') }}" method="POST" id="workflow-form">
                @csrf
                
                {{-- STEP 1: SCOPE --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="section-title mb-3">Step 1: Define Track Scope</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Department (Category) *</label>
                                <select name="category_id" id="category_id" class="form-select select2" required>
                                    <option value="">Select Department</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Sub-Category (Optional)</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-select select2">
                                    <option value="">General (All Sub-Categories)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: BUILDER --}}
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="section-title mb-0">Step 2: Escalation Sequence</h6>
                            <div class="d-flex align-items-center gap-3">
                                <div class="total-sla-badge d-none" id="sla-counter-box">
                                    Total SLA: <span id="total-sla">0</span> Hours
                                </div>
                                <button type="button" class="btn btn-sm btn-indigo" id="add-step">
                                    <i class="bi bi-plus-circle me-1"></i> Add Level
                                </button>
                            </div>
                        </div>

                        <div id="steps-container"></div>

                        <div id="empty-state" class="text-center py-5 border rounded-3 bg-light mb-3">
                            <p class="text-muted">Select a Department and click "Add Level" to define the escalation path.</p>
                        </div>

                        <div class="text-end mt-4 pt-3 border-top">
                            <a href="{{ route('admin.master.workflows.index') }}" class="btn btn-link text-muted me-3 text-decoration-none">Cancel</a>
                            <button type="submit" class="btn btn-indigo px-5 py-2 fw-bold shadow">Save Departmental Track</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ROW TEMPLATE --}}
<script id="step-template" type="text/template">
    <div class="card step-card shadow-sm border">
        <div class="card-body py-3">
            <div class="row align-items-center g-3">
                <div class="col-auto">
                    <div class="step-number">{NUM}</div>
                </div>
                <div class="col">
                    <label class="small text-muted fw-bold d-block mb-1">Unique Role (Designation)</label>
                    <select name="steps[{INDEX}][designation_id]" class="form-select designation-dropdown" required>
                        <option value="">Select Role</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold d-block mb-1">SLA Limit (Hours)</label>
                    <div class="input-group">
                        <input type="number" name="steps[{INDEX}][sla_hours]" class="form-control sla-input" value="24" min="1" required>
                        <span class="input-group-text bg-white small">Hours</span>
                    </div>
                </div>
                <div class="col-auto pt-3">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step">
                        <i class="bi bi-trash3 fs-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</script>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let masterRoles = [];

    $(document).ready(function() {
        $('.select2').select2({ width: '100%' });

        // Helper: Update Total SLA
        function calculateTotalSla() {
            let total = 0;
            $('.sla-input').each(function() {
                total += parseInt($(this).val()) || 0;
            });
            $('#total-sla').text(total);
            $('#sla-counter-box').toggleClass('d-none', $('.step-card').length === 0);
        }

        // 1. Fetch Sub-Categories and Roles when Category changes
        $('#category_id').on('change', function() {
            const catId = $(this).val();
            $('#steps-container').empty();
            $('#empty-state').show();
            calculateTotalSla();

            if(catId) {
                // Controller Method: getSubCategories()
                $.get("{{ route('admin.master.workflows.get-subcategories') }}", { category_id: catId }, function(data) {
                    $('#subcategory_id').empty().append('<option value="">General (All Sub-Categories)</option>');
                    data.forEach(sub => $('#subcategory_id').append(`<option value="${sub.id}">${sub.name}</option>`));
                });

                // Controller Method: getEligibleDesignations()
                fetchRoles(catId, null);
            }
        });

        // 2. Refresh Roles when Sub-Category changes
        $('#subcategory_id').on('change', function() {
            const catId = $('#category_id').val();
            const subId = $(this).val();
            if(catId) fetchRoles(catId, subId);
        });

        function fetchRoles(catId, subId) {
            $.get("{{ route('admin.master.workflows.get-eligible-designations') }}", { 
                category_id: catId, 
                subcategory_id: subId 
            }, function(data) {
                masterRoles = data;
                // Update existing dropdowns if any
                $('.designation-dropdown').each(function() {
                    const currentVal = $(this).val();
                    $(this).empty().append('<option value="">Select Role</option>');
                    masterRoles.forEach(r => $(this).append(`<option value="${r.id}">${r.name}</option>`));
                    $(this).val(currentVal);
                });
            });
        }

        // 3. Dynamic Step Addition
        $('#add-step').click(function() {
            if(!$('#category_id').val()) { 
                alert('Please select a Department first.'); 
                return; 
            }
            $('#empty-state').hide();
            const idx = $('.step-card').length;
            let html = $('#step-template').html().replace(/{INDEX}/g, idx).replace(/{NUM}/g, idx + 1);
            const $newStep = $(html);
            
            // Populate roles
            $newStep.find('.designation-dropdown').append(masterRoles.map(r => `<option value="${r.id}">${r.name}</option>`).join(''));
            $('#steps-container').append($newStep);
            
            enforceUniqueRoles();
            calculateTotalSla();
        });

        // 4. Input Listeners
        $(document).on('change', '.designation-dropdown', enforceUniqueRoles);
        $(document).on('input', '.sla-input', calculateTotalSla);

        function enforceUniqueRoles() {
            const selectedIds = $('.designation-dropdown').map(function() { return $(this).val(); }).get().filter(id => id !== "");

            $('.designation-dropdown').each(function() {
                const currentVal = $(this).val();
                $(this).find('option').each(function() {
                    const optId = $(this).val();
                    if (optId !== "" && optId !== currentVal && selectedIds.includes(optId)) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                });
            });
        }

        $(document).on('click', '.remove-step', function() {
            $(this).closest('.step-card').remove();
            if($('.step-card').length === 0) $('#empty-state').show();
            reindexSteps();
            calculateTotalSla();
        });

        function reindexSteps() {
            $('.step-card').each(function(i) {
                $(this).find('.step-number').text(i + 1);
                $(this).find('select, input').each(function() {
                    const name = $(this).attr('name');
                    if(name) $(this).attr('name', name.replace(/steps\[\d+\]/, `steps[${i}]`));
                });
            });
            enforceUniqueRoles();
        }
    });
</script>
@endpush