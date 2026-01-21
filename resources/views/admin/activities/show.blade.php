@extends('layouts.admin')

@section('title', 'Activity Details')
@section('page_title', 'Activity Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">Activities</a></li>
    <li class="breadcrumb-item active">View Activity</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h4 class="card-title mb-0 text-primary">{{ $activity->title }}</h4>
                <a href="{{ route('admin.activities.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 mb-4 text-center">
                        <label class="fw-bold text-muted d-block mb-3 text-start">Activity Image</label>
                        <div class="img-container p-2 border rounded bg-light">
                            <img src="{{ asset('storage/' . $activity->image) }}" 
                                 alt="{{ $activity->title }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 400px;">
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Display Status</label>
                            <div class="mt-1">
                                <span class="badge py-2 px-3 {{ $activity->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    <i class="bi {{ $activity->status == 'active' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Description / Content</label>
                            <div class="p-3 bg-light rounded border mt-1" style="min-height: 200px; line-height: 1.6;">
                                {!! nl2br(e($activity->content)) !!}
                            </div>
                        </div>

                        <div class="border-top pt-3 row text-muted small">
                            <div class="col-sm-6">
                                <i class="bi bi-calendar-event me-1"></i> 
                                <strong>Created:</strong> {{ $activity->created_at->format('M d, Y | h:i A') }}
                            </div>
                            <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                                <i class="bi bi-pencil me-1"></i> 
                                <strong>Last Update:</strong> {{ $activity->updated_at->format('M d, Y | h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light text-end border-top">
                <a href="{{ route('admin.activities.edit', $activity->id) }}" class="btn btn-primary px-4">
                    <i class="bi bi-pencil-square me-2"></i> Edit This Activity
                </a>
            </div>
        </div>
    </div>
</div>
@endsection