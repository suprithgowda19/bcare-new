@extends('layouts.admin')

@section('title', 'Edit Workflow')
@section('page_title', 'Modify Escalation Railroad')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .card { border-radius: 15px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .step-card { border-left: 5px solid #ffa117; background: #fffcf8; margin-bottom: 20px; transition: all 0.2s; }
    .step-card:hover { transform: translateX(5px); }
    .step-number { width: 35px; height: 35px; background: #ffa117; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .section-title { font-size: 0.8rem; font-weight: 700; color: #8898aa; text-transform: uppercase; letter-spacing: 1px; }
    .btn-warning-custom { background-color: #ffa117; color: white; }
    .btn-warning-custom:hover { background-color: #e68a00; color: white; }
    .total-sla-badge { background: #fff8ee; color: #ffa117; border: 1px solid #ffe8cc; padding: 10px 20px; border-radius: 10px; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            {{-- Error Alerts --}}
            @if(session('error'))
                <div class="alert alert-danger mb-4 shadow-sm border-0">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.master.workflows.update', $workflow->id) }}" method="POST" id="workflow-form">
                @csrf
                @method('PUT')
                
                {{-- READ-ONLY SCOPE --}}
                <div class="card mb-4 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h6 class="section-title mb-3 text-muted">Track Identity (Locked)</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0 small fw-bold text-uppercase opacity-50">Department</p>
                                <p class="h6 font-700">{{ $workflow->category->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0 small fw-bold text-uppercase opacity-50">Sub-Category Scope</p>
                                <p class="h6 font-700">{{ $workflow->subcategory->name ?? 'General (All Sub-Categories)' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BUILDER --}}
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="section-title mb-0 text-primary">Modify Escalation Sequence</h6>
                            <div class="d-flex align-items-center gap-3">
                                <div class="total-sla-badge" id="sla-counter-box">
                                    Total SLA: <span id="total-sla">0</span> Hours
                                </div>
                                <button type="button" class="btn btn-sm btn-warning-custom" id="add-step">
                                    <i class="bi bi-plus-circle me-1"></i> Add Stage
                                </button>
                            </div>
                        </div>

                        <div id="steps-container">
                            @foreach($workflow->steps as $index => $step)
                            <div class="card step-card shadow-sm border">
                                <div class="card-body py-3">
                                    <div class="row align-items-center g-3">
                                        <div class="col-auto">
                                            <div class="step-number">{{ $index + 1 }}</div>
                                        </div>
                                        <div class="col">
                                            <label class="small text-muted fw-bold d-block mb-1 text-uppercase">Unique Role</label>
                                            <select name="steps[{{ $index }}][designation_id]" class="form-select designation-dropdown" required>
                                                <option value="{{ $step->designation_id }}" selected>{{ $step->designation->name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small text-muted fw-bold d-block mb-1 text-uppercase">SLA (Hours)</label>
                                            <div class="input-group">
                                                <input type="number" name="steps[{{ $index }}][sla_hours]" class="form-control sla-input" value="{{ $step->sla_hours }}" min="1" required>
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
                            @endforeach
                        </div>

                        <div class="text-end mt-4 pt-3 border-top">
                            <a href="{{ route('admin.master.workflows.index') }}" class="btn btn-link text-muted me-3 text-decoration-none">Cancel Changes</a>
                            <button type="submit" class="btn btn-warning-custom px-5 py-2 fw-bold shadow">Update Railroad Track</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- TEMPLATE FOR NEW STEPS --}}
<script id="step-template" type="text/template">
    <div class="card step-card shadow-sm border">
        <div class="card-body py-3">
            <div class="row align-items-center g-3">
                <div class="col-auto"><div class="step-number">{NUM}</div></div>
                <div class="col">
                    <label class="small text-muted fw-bold d-block mb-1 text-uppercase">Unique Role</label>
                    <select name="steps[{INDEX}][designation_id]" class="form-select designation-dropdown" required>
                        <option value="">Select Role</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold d-block mb-1 text-uppercase">SLA (Hours)</label>
                    <div class="input-group">
                        <input type="number" name="steps[{INDEX}][sla_hours]" class="form-control sla-input" value="24" min="1" required>
                        <span class="input-group-text bg-white small">Hours</span>
                    </div>
                </div>
                <div class="col-auto pt-3">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step"><i class="bi bi-trash3 fs-5"></i></button>
                </div>
            </div>
        </div>
    </div>
</script>
@endsection

@push('scripts')
<script>
    let masterRoles = [];
    const categoryId = "{{ $workflow->category_id }}";
    const subcategoryId = "{{ $workflow->subcategory_id }}";

    $(document).ready(function() {
        // Helper: Calculate Total SLA
        function calculateTotalSla() {
            let total = 0;
            $('.sla-input').each(function() {
                total += parseInt($(this).val()) || 0;
            });
            $('#total-sla').text(total);
        }

        // 1. Initial Load of Roles (Matches Controller AJAX Helper)
        $.get("{{ route('admin.master.workflows.get-eligible-designations') }}", { 
            category_id: categoryId,
            subcategory_id: subcategoryId 
        }, function(data) {
            masterRoles = data;
            
            $('.designation-dropdown').each(function() {
                const selected = $(this).val();
                $(this).empty().append('<option value="">Select Role</option>');
                masterRoles.forEach(r => {
                    $(this).append(`<option value="${r.id}" ${r.id == selected ? 'selected' : ''}>${r.name}</option>`);
                });
            });
            enforceUniqueRoles();
            calculateTotalSla();
        });

        // 2. Add Stage Logic
        $('#add-step').click(function() {
            const idx = $('.step-card').length;
            let html = $('#step-template').html().replace(/{INDEX}/g, idx).replace(/{NUM}/g, idx + 1);
            const $newStep = $(html);
            
            $newStep.find('.designation-dropdown').append(masterRoles.map(r => `<option value="${r.id}">${r.name}</option>`).join(''));
            $('#steps-container').append($newStep);
            
            enforceUniqueRoles();
            calculateTotalSla();
        });

        // 3. Unique Role Enforcement
        $(document).on('change', '.designation-dropdown', enforceUniqueRoles);
        $(document).on('input', '.sla-input', calculateTotalSla);

        function enforceUniqueRoles() {
            const selectedIds = $('.designation-dropdown').map(function() { return $(this).val(); }).get().filter(id => id !== "");
            
            $('.designation-dropdown').each(function() {
                const current = $(this).val();
                $(this).find('option').each(function() {
                    const optId = $(this).val();
                    if (optId !== "" && optId !== current && selectedIds.includes(optId)) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                });
            });
        }

        // 4. Removal & Reindexing (Updated Regex)
        $(document).on('click', '.remove-step', function() {
            $(this).closest('.step-card').remove();
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

        // 5. Submit Validation (Matches Controller uniqueness check)
        $('#workflow-form').on('submit', function(e) {
            const ids = $('.designation-dropdown').map(function() { return $(this).val(); }).get().filter(id => id !== "");
            if (ids.length !== [...new Set(ids)].length) {
                e.preventDefault();
                alert("Each escalation level must have a unique role assigned.");
                return false;
            }
        });
    });
</script>
@endpush