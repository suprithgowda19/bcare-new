@extends('layouts.admin')

@section('title', 'Service Details')
@section('page_title', 'Service Full Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
    <li class="breadcrumb-item active">View Service</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h4 class="card-title mb-0 text-primary">Service: {{ $service->title }}</h4>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 mb-4 text-center">
                        <label class="fw-bold text-muted d-block mb-3 text-start">Featured Image</label>
                        @if($service->image)
                            <div class="img-container p-2 border rounded bg-light">
                                <img src="{{ asset('storage/' . $service->image) }}" 
                                     alt="{{ $service->title }}" 
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 350px;">
                            </div>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded border" style="height: 250px;">
                                <i class="bi bi-image text-muted me-2"></i>
                                <span class="text-muted">No Image Available</span>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-7">
                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Current Status</label>
                            <div class="mt-1">
                                <span class="badge py-2 px-3 {{ $service->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    <i class="bi {{ $service->status == 'active' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                    {{ ucfirst($service->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Description</label>
                            <div class="p-3 bg-light rounded border mt-1" style="min-height: 150px; line-height: 1.6;">
                                {!! nl2br(e($service->content)) !!}
                            </div>
                        </div>

                        <div class="border-top pt-3 row text-muted small">
                            <div class="col-sm-6">
                                <i class="bi bi-calendar-plus me-1"></i> 
                                <strong>Created:</strong> {{ $service->created_at->format('M d, Y | h:i A') }}
                            </div>
                            <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                                <i class="bi bi-clock-history me-1"></i> 
                                <strong>Modified:</strong> {{ $service->updated_at->format('M d, Y | h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light text-end border-top">
                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-primary px-4">
                    <i class="bi bi-pencil-square me-2"></i> Edit This Service
                </a>
            </div>
        </div>
    </div>
</div>
@endsection