@extends('layouts.admin')

@section('title', 'View Content')
@section('page_title', 'Content Block Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.content.index') }}">Content</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0">Content Details</h5>
                <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="text-muted small fw-bold text-uppercase">Title</label>
                    <h3 class="text-primary mt-1">{{ $content->title }}</h3>
                </div>

                <div class="mb-4">
                    <label class="text-muted small fw-bold text-uppercase">Status</label>
                    <div class="mt-1">
                        <span class="badge py-2 px-3 {{ $content->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            <i class="bi {{ $content->status == 'active' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                            {{ ucfirst($content->status) }}
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small fw-bold text-uppercase">Body Content</label>
                    <div class="p-4 bg-light rounded border mt-1" style="line-height: 1.8; min-height: 200px;">
                        {!! nl2br(e($content->content)) !!}
                    </div>
                </div>

                <div class="border-top pt-3 row text-muted small mt-5">
                    <div class="col-sm-6">
                        <i class="bi bi-calendar-plus me-1"></i> 
                        <strong>Created:</strong> {{ $content->created_at->format('d M, Y | h:i A') }}
                    </div>
                    <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                        <i class="bi bi-clock-history me-1"></i> 
                        <strong>Last Updated:</strong> {{ $content->updated_at->format('d M, Y | h:i A') }}
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light text-end">
                <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-primary px-4">
                    <i class="bi bi-pencil-square me-2"></i> Edit Content
                </a>
            </div>
        </div>
    </div>
</div>
@endsection