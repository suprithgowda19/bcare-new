@extends('layouts.admin')

@section('title', 'Staff Details')
@section('page_title', 'Staff Details')

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.master.staff.index') }}">Staff</a>
    </li>
    <li class="breadcrumb-item active">View</li>
@endsection

@push('css')
<style>
    .details-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        background: #fff;
    }

    .details-table th {
        width: 30%;
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
        vertical-align: middle;
    }

    .details-table td {
        color: #111827;
        font-weight: 500;
        vertical-align: middle;
    }

    .badge-ward {
        background: #eef2ff;
        color: #4338ca;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 0.75rem;
        margin: 2px;
        display: inline-block;
    }

    .status-active {
        background: #ecfdf5;
        color: #065f46;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-inactive {
        background: #fef2f2;
        color: #991b1b;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">

        <div class="details-card">
            <div class="card-body p-4">

                <table class="table table-bordered details-table mb-0">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{ $staff->name }}</td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $staff->phone }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>{{ $staff->email }}</td>
                        </tr>

                        <tr>
                            <th>Category</th>
                            <td>{{ $staff->category->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Sub Category</th>
                            <td>{{ $staff->subCategory->name ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="{{ $staff->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Assigned Wards</th>
                            <td>
                                @if($staff->wards->count())
                                    @foreach($staff->wards as $ward)
                                        <span class="badge-ward">
                                            {{ $ward->number }} : {{ $ward->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">No wards assigned</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $staff->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.master.staff.edit', $staff->id) }}" class="btn btn-primary">
                        Edit
                    </a>
                    <a href="{{ route('admin.master.staff.index') }}" class="btn btn-secondary">
                        Back
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
