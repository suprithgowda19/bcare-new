@extends('layouts.public')

@section('title', 'ದೂರುಗಳು - ಬಸವನಗುಡಿ')

@section('nav_title')
    ದೂರುಗಳು
@endsection
@section('content')

    <div class="card card-style">
        <div class="content">
            <p>ನಿಮ್ಮ ಇತ್ತೀಚಿನ ದೂರುಗಳ ಪಟ್ಟಿಯನ್ನು ಕೆಳಗೆ ಕಾಣಬಹುದು.</p>
        </div>

        <div class="accordion mt-1" id="accordion-complaints">
            @forelse($complaints as $complaint)
                <div class="card card-style shadow-0 bg-highlight mb-1">
                    <h2>
                        <button class="btn accordion-btn color-white no-effect collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $complaint->id }}">

                            ದೂರು ID - SP-{{ $complaint->id }} <br>
                            ವರ್ಗ - {{ $complaint->category->name ?? 'N/A' }} <br>
                            ಸ್ಥಿತಿ - {{ ucfirst($complaint->status) ?? 'New' }}

                            <i class="fa fa-chevron-down font-13 accordion-icon"></i>
                        </button>
                    </h2>

                    <div id="collapse{{ $complaint->id }}" class="collapse bg-theme" data-bs-parent="#accordion-complaints">
                        <div class="row mb-0">
                            <div class="col-12 ps-0">
                                <div class="card card-style shadow-0 mb-0">
                                    <div class="content" style="margin: 20px 15px 15px 15px;">
                                        <div class="d-flex flex-column gap-1">
                                            <div class="d-flex flex-column">
                                                <h3>SP-{{ $complaint->id }} ವಿವರಗಳು</h3>
                                                <p style="color: #e9573f; font-size: 16px; font-weight: 600;">
                                                    {{ $complaint->subject }}
                                                </p>
                                            </div>

                                            <div class="profile-container w-100 mb-2 col-12 d-flex flex-column gap-1 align-items-center">
                                                <table class="table table-bordered mb-2">
                                                    <tbody>
                                                        <tr>
                                                            <th class="tablefont">ವರ್ಗ</th>
                                                            <td>{{ $complaint->category->name ?? 'General' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="tablefont">ವಿಳಾಸ</th>
                                                            <td>{{ $complaint->address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="tablefont">ದೂರು ದಾಖಲಿಸಲಾಗಿದೆ</th>
                                                            <td>{{ $complaint->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="tablefont">ಸ್ಥಿತಿ</th>
                                                            <td>{{ ucfirst($complaint->status) ?? 'New' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- NEW SECTION: Progress Timeline --}}
                                        <div class="divider mb-3"></div>
                                        <h3 class="mb-3">ಪ್ರಗತಿ ವರದಿ (Progress Updates)</h3>
                                        
                                        @if($complaint->updates && $complaint->updates->count() > 0)
                                            <div class="ms-2 ps-3 border-start border-blue-dark">
                                                @foreach($complaint->updates as $update)
                                                    <div class="mb-4 position-relative">
                                                        <i class="fa fa-circle color-highlight position-absolute" style="left:-21px; top:5px; font-size:10px;"></i>
                                                        <span class="d-block font-11 font-700 opacity-60">{{ $update->created_at->format('d M Y, h:i A') }}</span>
                                                        <span class="d-block font-13 font-800 color-theme">ಸ್ಥಿತಿ: {{ ucfirst($update->status) }}</span>
                                                        <p class="font-13 mb-1 mt-1 color-theme opacity-80">{{ $update->remarks ?? 'No remarks provided.' }}</p>
                                                        <small class="d-block font-10 color-blue-dark">ಸಿಬ್ಬಂದಿ: {{ $update->staff->name ?? 'System' }}</small>

                                                        {{-- Staff Verification Images --}}
                                                        @if(!empty($update->images))
                                                            <div class="row row-cols-3 g-2 mt-2">
                                                                @foreach($update->images as $vImg)
                                                                    <a href="{{ asset('storage/' . $vImg) }}" class="col" data-gallery="gallery-up-{{ $update->id }}">
                                                                        <img src="{{ asset('storage/' . $vImg) }}" class="img-fluid rounded-xs shadow-xl" alt="verification">
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="font-12 opacity-50 mb-3"><i class="fa fa-clock me-1"></i>ಸಿಬ್ಬಂದಿಯಿಂದ ಇನ್ನು ಯಾವುದೇ ಅಪ್‌ಡೇಟ್ ಬಂದಿಲ್ಲ.</p>
                                        @endif

                                        {{-- Original Images --}}
                                        <div class="divider mb-2"></div>
                                        <h3>ದೂರಿನ ಚಿತ್ರಗಳು</h3>
                                        <div class="row text-center row-cols-3 mb-0">
                                            @if (!empty($complaint->images))
                                                @foreach ($complaint->images as $image)
                                                    <a class="col" data-gallery="gallery-{{ $complaint->id }}"
                                                        href="{{ asset('storage/' . $image) }}"
                                                        title="{{ $image }}">
                                                        <img src="{{ asset('storage/' . $image) }}"
                                                            data-src="{{ asset('storage/' . $image) }}"
                                                            class="preload-img img-fluid rounded-xs" alt="img">
                                                    </a>
                                                @endforeach
                                            @else
                                                <p class="col-12 text-start font-11 opacity-50">ಚಿತ್ರಗಳು ಲಭ್ಯವಿಲ್ಲ</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="content text-center py-5">
                    <i class="fa fa-info-circle fa-3x color-highlight mb-3"></i>
                    <p>ಯಾವುದೇ ದೂರುಗಳು ಕಂಡುಬಂದಿಲ್ಲ (No complaints found)</p>
                </div>
            @endforelse
        </div>
    </div>
    
    {{-- Pagination --}}
    <div class="mt-4 mb-4 d-flex justify-content-center">
        {{ $complaints->links('partials.pagination') }}
    </div>
@endsection