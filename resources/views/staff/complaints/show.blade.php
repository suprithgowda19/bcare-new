@extends('layouts.staff')

@section('content')
<div class="page-content">

    {{-- 1. HEADER: TICKET IDENTITY --}}
    <div class="card card-style">
        <div class="content">
            <div class="d-flex mb-3">
                <div>
                    <span class="badge bg-highlight color-white px-2 py-1 mb-2">SP-{{ $complaint->id }}</span>
                    <h1 class="font-700 mb-0">{{ $complaint->category->name }}</h1>
                    <p class="font-12 opacity-50"><i class="fa fa-map-marker-alt me-1"></i> Ward: {{ $complaint->ward->name }}</p>
                </div>
                <div class="ms-auto text-end">
                    <span class="badge {{ $complaint->status == 'resolved' ? 'bg-green-dark' : 'bg-warning' }} text-white d-block mb-1">
                        {{ strtoupper($complaint->status) }}
                    </span>
                    <p class="font-10 mb-0">{{ $complaint->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <div class="divider mb-3"></div>

            <h5 class="font-600">Citizen Details</h5>
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-user-circle font-30 color-theme opacity-30 me-3"></i>
                <div>
                    <h5 class="font-14 mb-n1">{{ $complaint->user->name }}</h5>
                    <p class="font-11 opacity-50 mb-0">{{ $complaint->user->phone ?? 'No Phone' }}</p>
                </div>
            </div>

            <div class="bg-fade-gray-light p-3 rounded-s">
                <p class="line-height-m color-theme font-13 mb-0">
                    <strong>Complaint:</strong> {{ $complaint->description ?? 'No detailed description provided.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. RAILROAD TRACKER (The "Active Station" UI) --}}
    @include('staff.partials.railroad_tracker', ['complaint' => $complaint])

    {{-- 3. INTERACTIVE TIMELINE (Audit Trail) --}}
    <div class="card card-style">
        <div class="content">
            <h4 class="font-700 mb-4">Action History</h4>
            
            <div class="timeline-body">
                @forelse($complaint->updates as $update)
                    <div class="timeline-item d-flex mb-4">
                        <div class="timeline-icon me-3">
                            @if($update->action_type == 'comment')
                                <i class="fa fa-comment bg-blue-dark color-white rounded-xl p-2 font-12"></i>
                            @else
                                <i class="fa fa-arrow-circle-right bg-highlight color-white rounded-xl p-2 font-12"></i>
                            @endif
                        </div>
                        <div class="timeline-content w-100">
                            <div class="d-flex justify-content-between">
                                <h5 class="font-14 font-700 mb-0">{{ $update->actedBy->name ?? 'System' }}</h5>
                                <span class="font-10 opacity-50">{{ $update->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="font-12 mb-2">{{ $update->remarks }}</p>
                            
                            {{-- Evidence Images --}}
                            @if($update->images)
                                <div class="d-flex gap-2">
                                    @foreach($update->images as $path)
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $path) }}" width="60" class="rounded-s shadow-s">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center opacity-30 py-3">No updates yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- 4. ACTION FORM (Only visible if status is not resolved) --}}
    @if($complaint->status !== 'resolved')
        @include('staff.partials.action_form', ['complaint' => $complaint])
    @endif

</div>

<style>
    .timeline-body { border-left: 1px solid rgba(0,0,0,0.05); margin-left: 15px; padding-left: 20px; }
    .timeline-icon { margin-left: -33px; position: relative; z-index: 2; }
</style>
@endsection