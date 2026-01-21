@extends('layouts.admin')

@section('title', 'Banner Details')
@section('page_title', 'Banner Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
    <li class="breadcrumb-item active">View Banner</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h4 class="card-title mb-0 text-primary">{{ $banner->title }}</h4>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="fw-bold text-muted small text-uppercase d-block mb-3">Banner Preview</label>
                        <div class="border rounded p-2 bg-light">
                            <img src="{{ asset('storage/' . $banner->image) }}" 
                                 alt="{{ $banner->title }}" 
                                 class="img-fluid rounded shadow-sm w-100"
                                 style="max-height: 400px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Status</label>
                            <div class="mt-1">
                                <span class="badge py-2 px-3 {{ $banner->status ? 'bg-success' : 'bg-danger' }}">
                                    <i class="bi {{ $banner->status ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                    {{ $banner->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Banner Content</label>
                            <div class="p-3 bg-light rounded border mt-1" style="min-height: 100px; line-height: 1.6;">
                                {{ $banner->content ?? 'No additional content provided.' }}
                            </div>
                        </div>

                        <div class="border-top pt-3 row text-muted small mt-5">
                            <div class="col-sm-6">
                                <i class="bi bi-clock me-1"></i> 
                                <strong>Created:</strong> {{ $banner->created_at->format('M d, Y') }}
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <i class="bi bi-arrow-repeat me-1"></i> 
                                <strong>Last Updated:</strong> {{ $banner->updated_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light text-end border-top">
                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-primary px-4">
                    <i class="bi bi-pencil-square me-2"></i> Edit This Banner
                </a>
            </div>
        </div>
    </div>
</div>
@endsection