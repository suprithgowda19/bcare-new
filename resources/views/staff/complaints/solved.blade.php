@extends('layouts.staff')

@section('title', 'Resolved Complaints')

@section('nav_title')
    Solved Complaints
@endsection

@section('style')
    <style>
        .table>:not(caption)>*>* {
            border: 1px solid #00000038 !important;
            font-size: 14px !important;
        }
    </style>
@endsection

@section('content')

<div class="card card-style">
    <div class="content text-center pt-4" style="overflow-x:auto;">

        <table class="table table-borderless text-center rounded-sm shadow-l">
            <thead>
                <tr style="background-color:#e45b44 !important;" class="text-white">
                    <th>Sl No.</th>
                    <th>Ticket ID</th>
                    <th>Category</th>
                    <th>Ward</th>
                    <th>Resolved On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($complaints as $complaint)
                    <tr>
                        {{-- Serial Number with Pagination --}}
                        <td>
                            {{ ($complaints->currentPage() - 1) * $complaints->perPage() + $loop->iteration }}
                        </td>

                        <td class="font-700">
                            SP-{{ $complaint->id }}
                        </td>

                        <td>
                            {{ $complaint->category->name ?? '-' }}
                        </td>

                        <td>
                            {{ $complaint->ward->name ?? '-' }}
                        </td>

                        <td>
                            {{ $complaint->updated_at->format('d M Y') }}
                        </td>

                        <td>
                            <a class="btn btn-sm"
                               style="background-color:rgba(0,0,0,0.05); border-color:#0000005e;"
                               href="{{ route('staff.complaints.show', $complaint->id) }}">
                                <i class="fa fa-eye" style="color:black"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 opacity-50">
                            No resolved complaints found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ✅ SAME PAGINATION PARTIAL AS DASHBOARD --}}
        @if ($complaints->hasPages())
            {{ $complaints->links('partials.pagination') }}
        @endif

    </div>
</div>

@endsection
