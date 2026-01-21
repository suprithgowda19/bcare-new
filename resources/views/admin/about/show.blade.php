@extends('layouts.admin')

@section('title', 'View About Content')
@section('page_title', 'About Section Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0">Content Details</h5>
                <a href="{{ route('admin.about.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 mb-4">
                        <label class="text-muted small fw-bold text-uppercase">Section Image</label>
                        <div class="mt-2 border rounded p-2 bg-light">
                            <img src="{{ asset('storage/' . $about->image) }}" 
                                 alt="{{ $about->title }}" 
                                 class="img-fluid rounded shadow-sm">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="mb-4">
                            <label class="text-muted small fw-bold text-uppercase">Title</label>
                            <h3 class="text-primary mt-1">{{ $about->title }}</h3>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small fw-bold text-uppercase">Status</label>
                            <div class="mt-1">
                                <span class="badge py-2 px-3 {{ $about->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($about->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small fw-bold text-uppercase">Full Content</label>
                            <div class="p-3 bg-light rounded border mt-1" style="line-height: 1.8;">
                                {!! nl2br(e($about->content)) !!}
                            </div>
                        </div>

                        <div class="row text-muted small mt-5 border-top pt-3">
                            <div class="col-6">
                                <strong>Date Added:</strong> {{ $about->created_at->format('d M, Y | H:i A') }}
                            </div>
                            <div class="col-6 text-end">
                                <strong>Last Modified:</strong> {{ $about->updated_at->format('d M, Y | H:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light text-end">
                <a href="{{ route('admin.about.edit', $about->id) }}" class="btn btn-primary px-4">
                    <i class="bi bi-pencil-square me-2"></i> Edit Content
                </a>
            </div>
        </div>
    </div>
</div>
@endsection