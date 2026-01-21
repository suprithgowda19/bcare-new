@extends('layouts.public')

@section('title') ವಿವರಗಳು - SP-{{ $complaint->id }} @endsection

@section('content')
<div class="page-content" style="min-height:60vh!important">
    
    {{-- Main Ticket Details Card --}}
    <div class="card card-style mt-n5">
        <div class="content">
            <div class="d-flex flex-column gap-1">
                <div class="d-flex flex-column mb-3">
                    <h3 class="font-700">SP-{{ $complaint->id }} ವಿವರಗಳು</h3>
                    <p class="color-highlight font-600 mb-0">{{ $complaint->subject }}</p>
                </div>

                <div class="profile-container w-100 mb-2">
                    <table class="table table-bordered mb-2 font-13">
                        <tbody>
                            <tr>
                                <th style="color:#e45b44;" class="w-40"><b>ವಿಷಯ</b></th>
                                <td>{{ $complaint->category->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="color:#e45b44;"><b>ವರ್ಗ</b></th>
                                <td>{{ $complaint->category->name ?? 'General' }}</td>
                            </tr>
                            <tr>
                                <th style="color:#e45b44;"><b>ಉಪವರ್ಗ</b></th>
                                <td>{{ $complaint->subcategory->name ?? 'No subcategory found' }}</td>
                            </tr>
                            <tr>
                                <th style="color:#e45b44;"><b>ವಿಳಾಸ</b></th>
                                <td class="line-height-s">{{ $complaint->address }}</td>
                            </tr>
                            <tr>
                                <th style="color:#e45b44;"><b>ದೂರು ದಾಖಲಿಸಲಾಗಿದೆ</b></th>
                                <td>{{ $complaint->created_at->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <th style="color:#e45b44;"><b>ಸ್ಥಿತಿ</b></th>
                                <td>
                                    @php
                                        $statusLabel = match($complaint->status) {
                                            'resolved'    => 'Completed',
                                            'in-progress' => 'In Progress',
                                            default       => ucfirst($complaint->status)
                                        };
                                    @endphp
                                    <span class="font-700 color-theme">{{ $statusLabel }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="divider mt-3 mb-3"></div>
            
            {{-- Citizen Uploaded Images --}}
            <h3 class="font-700">ಚಿತ್ರಗಳು (Citizen Uploads)</h3>
            <div class="row text-center row-cols-3 mb-2 g-2">
                @forelse($complaint->images ?? [] as $image)
                    <a class="col" data-gallery="gallery-1"
                       href="{{ asset('storage/' . $image) }}"
                       title="Original Image">
                        <img src="{{ asset('storage/' . $image) }}"
                             class="img-fluid rounded-xs shadow-m"
                             alt="complaint-image">
                    </a>
                @empty
                    <p class="col-12 text-start font-11 opacity-50 ps-3">
                        ಯಾವುದೇ ಚಿತ್ರಗಳಿಲ್ಲ
                    </p>
                @endforelse
            </div>

            <div class="divider mt-4 mb-3"></div>

            {{-- Staff Updates & Remarks --}}
            <h3 class="font-700">ಸಿಬ್ಬಂದಿ ನವೀಕರಣ (Staff Updates)</h3>
            @forelse($complaint->updates as $update)
                <div class="mb-4 ps-2 border-start border-highlight">
                    <div class="font-11 font-700 opacity-50 uppercase mb-n1">
                        {{ $update->created_at->format('d M, Y') }}
                    </div>

                    <div class="mb-2" style="text-align:left;">
                        <strong class="color-theme">Remarks:</strong>
                        {{ $update->remarks }}
                    </div>

                    {{-- Staff Verification Images --}}
                    <div class="row text-center row-cols-3 mb-0 g-2">
                        @foreach($update->images ?? [] as $vImg)
                            <a class="col" data-gallery="gallery-staff"
                               href="{{ asset('storage/' . $vImg) }}"
                               title="Staff Verification">
                                <img src="{{ asset('storage/' . $vImg) }}"
                                     class="img-fluid rounded-xs shadow-m"
                                     alt="staff-image">
                            </a>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="font-12 opacity-50">
                    ಇನ್ನೂ ಯಾವುದೇ ನವೀಕರಣಗಳಿಲ್ಲ (No updates yet).
                </p>
            @endforelse
        </div>
    </div>
</div>
@endsection
