@extends('layouts.admin')

@section('title', 'Staff Profile - ' . $staff->name)
@section('page_title', 'Staff Member Audit')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.master.staff.index') }}">Staff List</a></li>
    <li class="breadcrumb-item active">Audit Profile</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        {{-- Sidebar: Basic Identity & Contact --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-light-primary text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: 800;">
                        {{ strtoupper(substr($staff->name, 0, 1)) }}
                    </div>
                    <h4 class="mb-1 fw-bold text-dark">{{ $staff->name }}</h4>
                    <p class="text-primary fw-600 mb-3">{{ $staff->designation->name ?? 'Unassigned Role' }}</p>
                    
                    <div class="d-flex justify-content-center mb-4">
                        <span class="badge {{ $staff->status == 'active' ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }} px-3 py-2 rounded-pill border">
                            <i class="bi bi-circle-fill me-1 small"></i> {{ strtoupper($staff->status ?? 'ACTIVE') }} Account
                        </span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.master.staff.edit', $staff->id) }}" class="btn btn-primary shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-light-soft border-top py-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <h5 class="mb-0 fw-bold">{{ $staff->wards->count() }}</h5>
                            <small class="text-muted text-uppercase font-10">Wards Assigned</small>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0 fw-bold text-primary">Live</h5>
                            <small class="text-muted text-uppercase font-10">System Access</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>Contact Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small d-block mb-1 text-uppercase fw-bold opacity-50">Email Address</label>
                        <span class="fw-medium text-dark">{{ $staff->email }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small d-block mb-1 text-uppercase fw-bold opacity-50">Mobile Phone</label>
                        <span class="fw-medium text-dark"><i class="bi bi-phone me-1"></i>+91 {{ $staff->phone }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content: Assignments & Geography --}}
        <div class="col-xl-8 col-lg-7">
            {{-- Professional Context --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-briefcase me-2"></i>Departmental Allocation</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="p-3 border rounded bg-light-soft">
                                <label class="text-muted small d-block mb-1 text-uppercase fw-bold">Primary Department</label>
                                <h6 class="fw-bold mb-0 text-dark">
                                    {{ $staff->designation->category->name ?? 'General Administration' }}
                                </h6>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border rounded bg-light-soft">
                                <label class="text-muted small d-block mb-1 text-uppercase fw-bold">Specialization</label>
                                <h6 class="fw-bold mb-0 text-dark">
                                    {{ $staff->designation->subCategory->name ?? 'Field Operations (General)' }}
                                </h6>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center opacity-70">
                                <i class="bi bi-calendar-check me-2"></i>
                                <span class="small">Onboarded into System on <strong>{{ $staff->created_at->format('d M, Y') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ward Jurisdictions with Geographic Path --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2"></i>Geographic Jurisdictions</h6>
                    <span class="badge bg-indigo-soft text-indigo px-3">{{ $staff->wards->count() }} Managed Area(s)</span>
                </div>
                <div class="card-body p-4">
                    @if($staff->wards->isNotEmpty())
                        <div class="row g-3">
                            @foreach($staff->wards as $ward)
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-white h-100 shadow-sm border-start border-primary border-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-0 fw-800 text-dark">Ward {{ $ward->number }}</h6>
                                                <small class="text-primary fw-bold text-uppercase" style="font-size: 10px;">{{ $ward->name }}</small>
                                            </div>
                                            <i class="bi bi-pin-map-fill text-danger opacity-50"></i>
                                        </div>
                                        
                                        {{-- Full Path (Leverages Controller Eager Loading) --}}
                                        <div class="mt-3 pt-2 border-top">
                                            <p class="mb-0 text-muted" style="font-size: 11px;">
                                                <i class="bi bi-arrow-right-short"></i> 
                                                {{ $ward->constituency->name ?? 'N/A' }} 
                                                <span class="mx-1">/</span> 
                                                {{ $ward->constituency->zone->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-geo text-muted display-4 d-block mb-3 opacity-20"></i>
                            <p class="text-muted">This staff member currently has no active ward assignments.</p>
                            <a href="{{ route('admin.master.staff.edit', $staff->id) }}" class="btn btn-sm btn-primary px-4">
                                <i class="bi bi-plus-lg me-1"></i> Assign Wards Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection