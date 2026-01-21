@extends('layouts.staff')

@section('title')
    Staff Complaints
@endsection

@section('style')
    <style>
        .table>:not(caption)>*>* {
            border: 1px solid #00000038 !important;
            font-size: 14px !important;
        }

        .btn-outline-primary.active {
            background-color: #e45b44;
            border-color: #00000078;
        }
    </style>
@endsection

@section('content')

    {{-- Error Alert --}}
    @if (session('error'))
        <div class="ms-3 me-3 mb-3 alert alert-small rounded-s shadow-xl bg-red-dark text-white">
            {{ session('error') }}
        </div>
    @endif

    <div class="card card-style">
        <div class="content text-center pt-4" style="overflow-x:auto;">

            <table class="table table-borderless text-center rounded-sm shadow-l">
                <thead>
                    <tr style="background-color:#e45b44 !important;" class="text-white">
                        <th>Sl No.</th>
                        <th>Ticket ID</th>
                        <th>Category</th>
                        <th>Ward</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($complaints as $complaint)
                        <tr>
                            <td>
                                {{ ($complaints->currentPage() - 1) * $complaints->perPage() + $loop->iteration }}
                            </td>

                            <td class="font-700">SP-{{ $complaint->id }}</td>

                            <td>{{ $complaint->category->name ?? '-' }}</td>

                            <td>{{ $complaint->ward->name ?? '-' }}</td>

                            <td>
                                @php
                                    $pColor = match ($complaint->priority) {
                                        'urgent' => 'bg-red-dark',
                                        'high' => 'bg-warning',
                                        'medium' => 'bg-blue-dark',
                                        default => 'bg-green-dark',
                                    };
                                @endphp
                                <span class="badge {{ $pColor }} text-white">
                                    {{ strtoupper($complaint->priority) }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $sColor = match ($complaint->status) {
                                        'resolved' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'in-progress' => 'bg-blue-dark',
                                        'rejected' => 'bg-red-dark',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $sColor }} text-white">
                                    {{ ucfirst(str_replace('-', ' ', $complaint->status)) }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- View --}}
                                    <a class="btn btn-sm"
                                        style="background-color: rgba(0,0,0,0.05); border-color:#0000005e;"
                                        href="{{ route('staff.complaints.show', $complaint->id) }}">
                                        <i class="fa fa-eye" style="color:black"></i>
                                    </a>

                                    {{-- Update Status --}}
                                    @can('updateStatus', $complaint)
                                        @if ($complaint->status !== 'resolved')
                                            <a href="{{ route('staff.complaints.show', $complaint->id) }}#status-update"
                                                class="btn btn-sm"
                                                style="background-color: rgba(0,0,0,0.05); border-color:#0000005e;">
                                                <span style="white-space:nowrap;color:black">
                                                    Update Status
                                                </span>
                                            </a>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 opacity-50">
                                No complaints assigned
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($complaints->hasPages())
                {{ $complaints->links('partials.pagination') }}
            @endif


        </div>
    </div>

@endsection
