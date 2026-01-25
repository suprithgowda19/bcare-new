@extends('layouts.staff')

{{-- 1. Perfectly Aligned Navbar Content --}}
{{-- Pushes the title and back link to your layout's navbar partial --}}
@section('nav_title', 'ಉಪವರ್ಗಗಳು')
@section('back_url', route('public.complaints.category'))
@section('title', 'Select Sub-Category - ಉಪವರ್ಗಗಳು')

@push('styles')
<style>
    /* Professional White Card styling */
    .sub-category-card {
        background: #ffffff;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        padding: 30px 10px;
        transition: transform 0.2s ease;
    }

    .sub-category-card:active {
        transform: scale(0.95);
    }

    /* Large Circular Icon Wrapper (110px) centered inside the card */
    .sub-img-wrapper {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 15px auto;
        border: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sub-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Bold Title styling */
    .sub-title {
        font-weight: 700 !important;
        color: #333 !important;
        font-size: 15px !important;
        margin-bottom: 0;
    }

    .sub-link {
        text-decoration: none !important;
    }
</style>
@endpush

@section('content')
    {{-- 2. Current Selection Context --}}
    {{-- This text sits on top of the decorative header overlay provided by your layout --}}
    <div class="content text-center mt-0 mb-3">
        <p class="color-white opacity-80 mt-n4 mb-4">
            ಆಯ್ದ ವರ್ಗ: <strong class="color-white">{{ $category->name }}</strong>
        </p>
    </div>

    {{-- 3. Sub-Category Selection Grid --}}
    {{-- mt-n2 pulls cards up to overlap the header card background --}}
    <div class="row text-center mb-0 mt-n2">
        @forelse($sub_categories as $sub)
            <div class="col-6 {{ $loop->odd ? 'pe-2' : 'ps-2' }} mb-3">
                {{-- Link to Page 3: Final Complaint Form --}}
                <a href="{{ route('public.complaints.create', ['category_id' => $category->id, 'sub_category_id' => $sub->id]) }}" class="sub-link">
                    <div class="card sub-category-card h-100 shadow-xl">
                        <div class="center-text">
                            <div class="sub-img-wrapper shadow-sm">
                                @if($sub->image)
                                    <img src="{{ asset('storage/' . $sub->image) }}" alt="{{ $sub->name }}">
                                @else
                                    <i class="fa fa-layer-group font-40 color-highlight mt-4"></i>
                                @endif
                            </div>
                        </div>
                        <h4 class="sub-title">{{ $sub->name }}</h4>
                        <p class="font-10 opacity-40 mt-1 mb-0 text-uppercase font-700">ದೂರು ನೀಡಿ</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center mt-5">
                <p class="color-white font-16">ಈ ವರ್ಗಕ್ಕೆ ಉಪವರ್ಗಗಳು ಲಭ್ಯವಿಲ್ಲ.</p>
            </div>
        @endforelse
    </div>
@endsection