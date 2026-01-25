@extends('layouts.public')

@section('title', 'ಮುಖಪುಟ - Ravi Subramanya')

@section('content')

    {{-- 4. Dynamic News Cards --}}
    @forelse($news as $item)
        <div class="card card-style">
            <div class="content text-center pt-4">
                {{-- ಶೀರ್ಷಿಕೆ --}}
                <h6 class="font-700">{{ $item->title }}</h6>
                
                {{-- ವಿವರಣೆ --}}
                <p class="mb-1">{{ $item->about }}</p>
                
                {{-- ಚಿತ್ರ (ಮೊದಲಿನ ಫಾರ್ಮ್ಯಾಟ್‌ಗೆ ಬದಲಾಯಿಸಲಾಗಿದೆ) --}}
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" 
                         alt="{{ $item->title }}" 
                         width="150" 
                         height="auto">
                @endif
                
                <div class="pb-3"></div>
            </div>
        </div>
    @empty
        <div class="card card-style">
            <div class="content text-center py-4">
                <p>ಯಾವುದೇ ಸುದ್ದಿ ಲಭ್ಯವಿಲ್ಲ.</p>
            </div>
        </div>
    @endforelse

@endsection