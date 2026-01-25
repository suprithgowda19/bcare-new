@extends('layouts.admin')

@section('title', 'Public User Details')
@section('page_title', 'User Details')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.master.public.index') }}">Public Users</a>
    </li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $user->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Registered At</th>
                <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.master.public.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>
</div>

@endsection
