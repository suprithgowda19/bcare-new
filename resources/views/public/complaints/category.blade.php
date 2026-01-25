@extends('layouts.public')

{{-- 1. Dynamic Navbar Content --}}
{{-- These sections fill the placeholders in your Layout --}}
@section('nav_title', 'ವರ್ಗಗಳು')
@section('back_url', url('/')) {{-- Navigates back to the Home page --}}
@section('title', 'Select Category - ವರ್ಗಗಳು')

@push('styles')
<style>
    /* Styling for the large white rounded cards */
    .category-card {
        background: #ffffff;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        padding: 30px 10px;
        transition: transform 0.2s ease;
    }

    .category-card:active {
        transform: scale(0.95);
    }

    /* Styling for the circular images to match your screenshot */
    .round-img-wrapper {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 15px auto;
        border: 2px solid #f8f8f8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .round-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-name {
        font-weight: 700 !important;
        color: #333 !important;
        font-size: 16px !important;
        margin-bottom: 0;
    }

    .category-link {
        text-decoration: none !important;
    }
</style>
@endpush

@section('content')
    {{-- 2. Categories Grid --}}
    {{-- mt-n4 pulls the cards up so they overlap the header card background provided in your layout --}}
    <div class="row text-center mb-0 mt-n4">
        @forelse($categories as $category)
            <div class="col-6 {{ $loop->odd ? 'pe-2' : 'ps-2' }} mb-3">
                {{-- Variable $category is safely defined inside this loop --}}
                <a href="{{ route('public.complaints.sub_category', ['category_id' => $category->id]) }}" class="category-link">
                    <div class="card category-card h-100 shadow-xl">
                        <div class="center-text">
                            <div class="round-img-wrapper shadow-sm">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                @else
                                    {{-- Fallback image or icon --}}
                                    <i class="fa fa-th-large font-40 color-highlight mt-4"></i>
                                @endif
                            </div>
                        </div>
                        <h4 class="category-name">{{ $category->name }}</h4>
                        <p class="font-10 opacity-40 mt-1 mb-0 text-uppercase font-700">ಮುಂದುವರಿಯಿರಿ</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center mt-5">
                <p class="color-white font-16">ಯಾವುದೇ ವರ್ಗಗಳು ಲಭ್ಯವಿಲ್ಲ.</p>
            </div>
        @endforelse
    </div>

    {{-- 3. Guidance Card --}}
    <div class="card card-style mt-3">
        <div class="content">
            <h5 class="font-600">ಮಾಹಿತಿ</h5>
            <p class="font-12 opacity-60 mb-0">
                ನಿಮ್ಮ ಸಮಸ್ಯೆಗೆ ಸೂಕ್ತವಾದ ವರ್ಗವನ್ನು ಆರಿಸಿ. ಮುಂದಿನ ಹಂತದಲ್ಲಿ ನಾವು ಹೆಚ್ಚಿನ ವಿವರಗಳನ್ನು ಕೇಳುತ್ತೇವೆ.
            </p>
        </div>
    </div>
@endsection