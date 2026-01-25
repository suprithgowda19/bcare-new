@extends('layouts.public')

@section('title') ವಿವರಗಳು - SP-{{ $complaint->id }} @endsection

@section('content')
<div class="page-content" style="min-height:60vh!important">
    
    {{-- Header Status Card --}}
    <div class="card card-style bg-highlight mb-3 mt-n5">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="color-white font-800 mb-n1">SP-{{ $complaint->id }}</h1>
                    <p class="color-white opacity-70 mb-0 font-11 text-uppercase">ದೂರು ವಿವರಗಳು (Ticket Details)</p>
                </div>
                <div class="text-end">
                    @php
                        $badgeColor = match($complaint->status) {
                            'resolved' => 'bg-green-dark',
                            'in-progress', 'in_progress' => 'bg-blue-dark',
                            'rejected' => 'bg-red-dark',
                            default => 'bg-yellow-dark'
                        };
                    @endphp
                    <span class="badge {{ $badgeColor }} color-white px-3 py-2 font-12 shadow-s">
                        {{ strtoupper(str_replace('_', ' ', $complaint->status)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Railroad Tracker for Citizen --}}
    @if($complaint->workflow && $complaint->status !== 'resolved')
    <div class="card card-style mb-3">
        <div class="content mb-3">
            <p class="mb-n1 font-10 font-700 text-uppercase color-highlight">ಪ್ರಸ್ತುತ ಹಂತ (Active Station)</p>
            <h4 class="font-700">{{ $complaint->currentStep->designation->name ?? 'ಪರಿಶೀಲನೆಯಲ್ಲಿದೆ' }}</h4>
            
            @php 
                $totalSteps = $complaint->workflow->steps->count() ?: 1;
                $currentStepNum = $complaint->currentStep->step_number ?? 1;
                $progress = ($currentStepNum / $totalSteps) * 100;
            @endphp
            
            <div class="progress mt-3" style="height:8px;">
                <div class="progress-bar bg-highlight" style="width: {{ $progress }}%"></div>
            </div>
            <p class="font-10 text-center mt-2 opacity-50">ನಿಮ್ಮ ದೂರನ್ನು ಹಂತ ಹಂತವಾಗಿ ಪರಿಹರಿಸಲಾಗುತ್ತಿದೆ.</p>
        </div>
    </div>
    @endif

    {{-- Main Info --}}
    <div class="card card-style">
        <div class="content">
            <h5 class="font-700 mb-3">ಮೂಲ ವಿವರಗಳು (General Info)</h5>
            
            <div class="d-flex mb-3">
                <div class="align-self-center"><i class="fa fa-list-alt font-18 color-blue-dark w-40"></i></div>
                <div class="align-self-center"><p class="font-700 color-theme mb-0">ವರ್ಗ: <span class="font-400 ms-2">{{ $complaint->category->name }}</span></p></div>
            </div>
            
            <div class="d-flex mb-3">
                <div class="align-self-center"><i class="fa fa-map-marker-alt font-18 color-red-dark w-40"></i></div>
                <div class="align-self-center"><p class="font-700 color-theme mb-0">ವಿಳಾಸ: <span class="font-400 ms-2">{{ $complaint->address }}</span></p></div>
            </div>

            <div class="d-flex mb-3">
                <div class="align-self-center"><i class="fa fa-calendar-alt font-18 color-green-dark w-40"></i></div>
                <div class="align-self-center"><p class="font-700 color-theme mb-0">ದಾಖಲಿಸಿದ ದಿನಾಂಕ: <span class="font-400 ms-2">{{ $complaint->created_at->format('d-m-Y') }}</span></p></div>
            </div>

            @if($complaint->due_at)
            <div class="d-flex mb-0">
                <div class="align-self-center"><i class="fa fa-clock font-18 color-yellow-dark w-40"></i></div>
                <div class="align-self-center"><p class="font-700 color-theme mb-0">ನಿರೀಕ್ಷಿತ ಪರಿಹಾರ: <span class="font-400 ms-2">{{ $complaint->due_at->format('d-m-Y') }}</span></p></div>
            </div>
            @endif
        </div>
    </div>

    {{-- Citizen Uploaded Images --}}
    <div class="card card-style">
        <div class="content">
            <h5 class="font-700 mb-3">ನಿಮ್ಮ ಚಿತ್ರಗಳು (Citizen Photos)</h5>
            <div class="row text-center row-cols-3 mb-0 g-2">
                @forelse($complaint->images ?? [] as $image)
                    <a class="col" data-gallery="gallery-1" href="{{ asset('storage/' . $image) }}">
                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded-xs shadow-m">
                    </a>
                @empty
                    <p class="col-12 text-start font-11 opacity-50 ps-3">ಚಿತ್ರಗಳಿಲ್ಲ</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Professional Timeline for Staff Updates --}}
    <div class="card card-style">
        <div class="content">
            <h5 class="font-700 mb-4">ಅಪ್‌ಡೇಟ್ ಇತಿಹಾಸ (Resolution Timeline)</h5>
            
            @forelse($complaint->updates->where('is_public', true) as $update)
                <div class="timeline-item d-flex mb-4">
                    <div class="me-3">
                        <i class="fa fa-check-circle color-highlight font-18"></i>
                        <div class="timeline-line bg-highlight opacity-20" style="width:2px; height:100%; margin: 0 auto;"></div>
                    </div>
                    <div class="align-self-center w-100">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-14 font-700 mb-0">{{ $update->remarks }}</h6>
                            <span class="font-10 opacity-50">{{ $update->created_at->format('d M') }}</span>
                        </div>
                        <p class="font-12 mb-2 opacity-60">ಸ್ಥಿತಿ: {{ ucfirst($update->action_type) }}</p>
                        
                        <div class="row row-cols-4 g-2">
                            @foreach($update->images ?? [] as $vImg)
                                <a class="col" data-gallery="gallery-staff-{{ $update->id }}" href="{{ asset('storage/' . $vImg) }}">
                                    <img src="{{ asset('storage/' . $vImg) }}" class="img-fluid rounded-xs shadow-s">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-3">
                    <i class="fa fa-clock fa-3x opacity-10 mb-2"></i>
                    <p class="font-12 opacity-50">ಇನ್ನೂ ಯಾವುದೇ ನವೀಕರಣಗಳಿಲ್ಲ.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Back Action --}}
    <div class="content mb-5">
        <a href="{{ route('public.complaints.index') }}" class="btn btn-full btn-m rounded-s bg-highlight font-700 text-uppercase">ಹಿಂದಕ್ಕೆ (Back to List)</a>
    </div>

</div>
@endsection