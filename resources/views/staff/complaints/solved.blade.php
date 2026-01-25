@extends('layouts.staff')

@section('title', 'Resolved Complaints')

@section('nav_title')
    Solved Complaints
@endsection

@section('style')
    <style>
        .table>:not(caption)>*>* {
            border: 1px solid #00000038 !important;
            font-size: 13px !important;
        }
        .bg-resolved { background-color: #28a745 !important; }
    </style>
@endsection

@section('content')

<div class="card card-style">
    <div class="content text-center pt-4" style="overflow-x:auto;">

        <table class="table table-borderless text-center rounded-sm shadow-l">
            <thead>
                <tr class="bg-resolved text-white">
                    <th>Sl No.</th>
                    <th>Ticket ID</th>
                    <th>Category</th>
                    <th>Ward</th>
                    <th>Resolved On</th>
                    <th>View</th>
                </tr>
            </thead>

            <tbody>
                @forelse($complaints as $complaint)
                    <tr>
                        {{-- Handle both Collection and Paginator for safety --}}
                        <td>
                            @if($complaints instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ ($complaints->currentPage() - 1) * $complaints->perPage() + $loop->iteration }}
                            @else
                                {{ $loop->iteration }}
                            @endif
                        </td>

                        <td class="font-700">SP-{{ $complaint->id }}</td>

                        <td>{{ $complaint->category->name ?? 'General' }}</td>

                        <td>{{ $complaint->ward->name ?? '-' }}</td>

                        <td>
                            <span class="color-green-dark font-700">
                                {{ $complaint->updated_at->format('d M y') }}
                            </span>
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
                            No resolved complaints found in your jurisdiction.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if (method_exists($complaints, 'links') && $complaints->hasPages())
            <div class="mt-3">
                {{ $complaints->links('partials.pagination') }}
            </div>
        @endif

    </div>
</div>

@endsection