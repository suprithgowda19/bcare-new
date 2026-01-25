@extends('layouts.public')

@section('title', 'ದೂರುಗಳು - ಬಸವನಗುಡಿ')

@section('nav_title')
    ನನ್ನ ದೂರುಗಳು
@endsection

@section('content')
<div class="page-content">

    <div class="card card-style">
        <div class="content">
            <h4 class="font-700">ದೂರುಗಳ ಪಟ್ಟಿ (My Complaints)</h4>
            <p class="opacity-60">ನಿಮ್ಮ ದೂರುಗಳ ಪ್ರಗತಿಯನ್ನು ಪತ್ತೆಹಚ್ಚಲು ಕೆಳಗಿನ ಕಾರ್ಡ್‌ಗಳ ಮೇಲೆ ಕ್ಲಿಕ್ ಮಾಡಿ.</p>
        </div>
    </div>

    <div class="accordion mt-1" id="accordion-complaints">
        @forelse($complaints as $complaint)
            @php
                // Dynamic Status Colors
                $statusColor = match($complaint->status) {
                    'resolved' => 'bg-green-dark',
                    'pending' => 'bg-yellow-dark',
                    'rejected' => 'bg-red-dark',
                    default => 'bg-blue-dark',
                };
            @endphp

            <div class="card card-style shadow-0 {{ $statusColor }} mb-2">
                <h2 class="mb-0">
                    <button class="btn accordion-btn color-white no-effect collapsed py-3" 
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $complaint->id }}">
                        
                        <span class="font-11 opacity-70 d-block mb-n1">SP-{{ $complaint->id }}</span>
                        <span class="font-15 font-700">{{ $complaint->category->name ?? 'ದೂರು' }}</span>
                        <span class="d-block font-11 mt-1">
                            <i class="fa fa-info-circle me-1"></i>ಸ್ಥಿತಿ: {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>

                        <i class="fa fa-chevron-down font-10 accordion-icon color-white"></i>
                    </button>
                </h2>

                <div id="collapse{{ $complaint->id }}" class="collapse bg-theme" data-bs-parent="#accordion-complaints">
                    <div class="content mt-3">
                        
                        {{-- Quick Info Table --}}
                        <div class="bg-light-light p-2 rounded-s mb-3 border">
                            <table class="table table-borderless mb-0">
                                <tr class="font-12">
                                    <td class="font-700 py-1" style="width: 35%;">ವಿಷಯ:</td>
                                    <td class="py-1">{{ $complaint->subject }}</td>
                                </tr>
                                <tr class="font-12">
                                    <td class="font-700 py-1">ಸ್ಥಳ:</td>
                                    <td class="py-1">{{ $complaint->address }}</td>
                                </tr>
                                <tr class="font-12">
                                    <td class="font-700 py-1">ದಿನಾಂಕ:</td>
                                    <td class="py-1">{{ $complaint->created_at->format('d-m-Y') }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- Progress Timeline --}}
                        <h5 class="font-700 mb-3"><i class="fa fa-tasks color-blue-dark me-2"></i>ಪ್ರಗತಿ ವರದಿ (Timeline)</h5>
                        
                        {{-- Filter only public updates --}}
                        @php $publicUpdates = $complaint->updates->where('is_public', true); @endphp

                        @if($publicUpdates->count() > 0)
                            <div class="ms-2 ps-3 border-start border-blue-dark">
                                @foreach($publicUpdates as $update)
                                    <div class="mb-3 position-relative">
                                        <i class="fa fa-check-circle color-blue-dark position-absolute" style="left:-22px; top:2px; font-size:12px; background:#fff;"></i>
                                        <span class="d-block font-10 opacity-50">{{ $update->created_at->format('d M, h:i A') }}</span>
                                        <span class="font-12 font-700">{{ $update->remarks }}</span>
                                        
                                        @if(!empty($update->images))
                                            <div class="d-flex gap-1 mt-2">
                                                @foreach($update->images as $vImg)
                                                    <a href="{{ asset('storage/' . $vImg) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $vImg) }}" width="50" class="rounded-xs shadow-s">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-fade-blue-light p-3 rounded-s mb-3">
                                <p class="font-11 mb-0 color-blue-dark">
                                    <i class="fa fa-info-circle me-1"></i>ನಿಮ್ಮ ದೂರನ್ನು ಸ್ವೀಕರಿಸಲಾಗಿದೆ. ಶೀಘ್ರದಲ್ಲೇ ಅಧಿಕಾರಿಗಳು ಪರಿಶೀಲಿಸಲಿದ್ದಾರೆ.
                                </p>
                            </div>
                        @endif

                        {{-- Original Evidence --}}
                        <div class="divider mb-3 mt-3"></div>
                        <h5 class="font-700 mb-2">ದೂರಿನ ಚಿತ್ರಗಳು (Evidence)</h5>
                        <div class="row text-center row-cols-4 g-2 mb-0">
                            @if (!empty($complaint->images))
                                @foreach ($complaint->images as $image)
                                    <a class="col" href="{{ asset('storage/' . $image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded-xs shadow-sm">
                                    </a>
                                @endforeach
                            @else
                                <p class="col-12 text-start font-11 opacity-50 italic">ಚಿತ್ರಗಳು ಲಭ್ಯವಿಲ್ಲ</p>
                            @endif
                        </div>

                        {{-- Action Button --}}
                        <div class="divider mt-3 mb-3"></div>
                        <a href="{{ route('public.complaints.show', $complaint->id) }}" class="btn btn-full btn-s rounded-s bg-highlight font-700 text-uppercase w-100">ಪೂರ್ಣ ವಿವರ ನೋಡಿ (Full Details)</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card card-style py-5 text-center">
                <i class="fa fa-folder-open fa-4x color-highlight mb-3"></i>
                <h5 class="font-700">ಯಾವುದೇ ದೂರುಗಳು ಇಲ್ಲ</h5>
                <p class="mb-0">ನೀವು ಇನ್ನು ಯಾವುದೇ ದೂರನ್ನು ದಾಖಲಿಸಿಲ್ಲ.</p>
                <a href="{{ route('public.complaints.category') }}" class="btn btn-m bg-highlight rounded-sm font-700 mt-3">ದೂರು ಸಲ್ಲಿಸಿ</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="content mt-0 mb-5">
        {{ $complaints->links('partials.pagination') }}
    </div>

</div>
@endsection