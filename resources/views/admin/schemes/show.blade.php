@extends('layouts.admin')

@section('page_title', 'Scheme Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card text-center p-4">
            <div class="mb-3">
                <img src="{{ Storage::url($scheme->image) }}" width="100">
            </div>
            <h1 class="display-4 font-weight-bold text-primary">{{ $scheme->count }}</h1>
            <h3>{{ $scheme->title }}</h3>
            <p class="text-muted">Status: {{ ucfirst($scheme->status) }}</p>
            <div class="mt-3">
                <a href="{{ route('admin.schemes.index') }}" class="btn btn-light">Back</a>
                <a href="{{ route('admin.schemes.edit', $scheme->id) }}" class="btn btn-primary">Edit This</a>
            </div>
        </div>
    </div>
</div>
@endsection