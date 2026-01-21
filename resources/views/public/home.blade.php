@extends('layouts.public')

@section('title', 'ಮುಖಪುಟ - Ravi Subramanya')

@section('content')

    <div class="content mb-3 mt-0">
        <h5 class="float-start font-16 font-500">ಬಸವನಗುಡಿ ಸುದ್ದಿ</h5>
        <a class="float-end font-12 color-highlight mt-n1" href="#">ಎಲ್ಲವನ್ನೂ ವೀಕ್ಷಿಸಿ</a>
        <div class="clearfix"></div>
    </div>
    <div class="splide single-slider slider-no-arrows slider-no-dots homepage-slider" id="single-slider-1">
        <div class="splide__track">
            <div class="splide__list">
                @foreach ($banners as $banner)
                    <div class="splide__slide">
                        <div class="card rounded-l mx-2 text-center shadow-l" data-card-height="320"
                            style="background-image: url({{ Storage::url($banner->image) }}); height: 320px;">
                            <div class="card-bottom">
                                <h1 class="font-24 font-700 ">{{ $banner->title }}</h1>
                                <p class="boxed-text-xl ">{{ $banner->content }}</p>
                            </div>
                            <div class="card-overlay bg-gradient-fade"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="content mt-0">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('complaints.category') }}"
                    class="btn btn-full btn-m rounded-s text-uppercase font-900 shadow-xl bg-highlight">ದೂರನ್ನು
                    ನೋಂದಾಯಿಸಿ</a>
            </div>
            <div class="col-6">
                <a href="{{ route('complaints.index') }}" class="btn btn-full btn-m rounded-s text-uppercase font-900 shadow-xl bg-highlight">ನನ್ನ
                    ದೂರುಗಳು</a>
            </div>
        </div>
    </div>

    <div class="content mb-3 mt-0">
        <h5 class="float-start font-16 font-500">ಬಸವನಗುಡಿ ಸುದ್ದಿ</h5>
        <a class="float-end font-12 color-highlight mt-n1" href="#">ಎಲ್ಲವನ್ನೂ ವೀಕ್ಷಿಸಿ</a>
        <div class="clearfix"></div>
    </div>
    <div class="splide double-slider visible-slider slider-no-arrows slider-no-dots" id="double-slider-2">
        <div class="splide__track">
            <div class="splide__list">
                @foreach ($news as $item)
                    <div class="splide__slide ps-3">
                        <div class="bg-theme pb-3 rounded-m shadow-l text-center overflow-hidden">
                            <div data-card-height="150" class="card mb-2 preload-img"
                                data-src="{{ Storage::url($item->image) }}"
                                style="background-image: url({{ Storage::url($item->image) }}); height: 150px;">

                                <h5 class="card-bottom color-white mb-2">{{ $item->title }}</h5>
                                <div class="card-overlay bg-gradient"></div>
                            </div>

                            <p class="mb-3 ps-2 pe-2 pt-2 font-12">
                                {{ Str::limit($item->about, 80) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="content mb-2">
        <h5 class="float-start font-16 font-500">ಚಟುವಟಿಕೆಗಳು / ಸೇವೆಗಳು</h5>
        <a class="float-end font-12 color-highlight mt-n1" href="#">ಎಲ್ಲವನ್ನೂ ವೀಕ್ಷಿಸಿ</a>
        <div class="clearfix"></div>
    </div>

    <div class="splide double-slider visible-slider slider-no-arrows slider-no-dots" id="double-slider-1">
        <div class="splide__track">
            <div class="splide__list">
                @foreach ($activities as $activity)
                    <div class="splide__slide ps-3">
                        <div class="bg-theme rounded-m shadow-m text-center h-240 mb-4">
                            <img class="rounded-circle mt-4 mb-4 object-cover" width="90" height="90"
                                src="{{ Storage::url($activity->image) }}" alt="{{ $activity->title }}">

                            <h5 class="font-16">{{ $activity->title }}</h5>

                            <p class="line-height-s font-11 pb-4 px-2">
                                {{ Str::limit($activity->content, 60) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card bg-20 mb-4">
        <div class="card-body">
            <h2 class="color-white font-600 mb-4 pt-3 text-center">ಬಸವನಗುಡಿ ನವೀಕರಣಗಳು</h2>
            <div class="splide3 splide single-slider slider-no-arrows slider-no-dots visible-slider" id="double-slider-6">
                <div class="splide__track">
                    <div class="splide__list">
                        @foreach ($updates as $update)
                            <div class="splide__slide">
                                <div class="card card-style mx-2">
                                    <img src="{{ Storage::url($update->image) }}" class="img-fluid"
                                        style="height: 276px; object-fit: cover;">

                                    <div class="d-flex mt-n2 ms-3">
                                        <span
                                            class="badge bg-red-dark text-uppercase">{{ $update->tag_name ?? 'ನವೀಕರಣ' }}</span>
                                    </div>

                                    <div class="content">
                                        <h4>{{ Str::limit($update->title, 25) }}</h4>

                                        <p>{{ Str::limit($update->about, 80) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="card-overlay rounded-0 bg-highlight opacity-95"></div>
    </div>

    <div data-card-height="230" class="card card-style round-medium shadow-huge top-30">
        <div class="card-top mt-3">
            <div class="d-flex justify-content-between align-items-center px-3">
                <h4 class="color-white font-700">ಬಸವನಗುಡಿ ಕಾರ್ಯಕ್ರಮ</h4>
                <a href="#" class="bg-white color-black btn btn-s rounded-xl font-900 font-11">ಕಾರ್ಯಕ್ರಮ
                    ಸೇರಿಕೊಳ್ಳಿ</a>
            </div>
            <p class="color-white ms-3 font-10 opacity-80 mb-n1"><i class="far fa-calendar"></i> November 30 <i
                    class="ms-4 far fa-clock"></i> 12:00 am</p>
            <p class="color-white ms-3 font-10 opacity-80"><i class="fa fa-map-marker-alt"></i> ಬಸವನಗುಡಿ</p>
        </div>
        <div class="card-bottom pb-3 pe-4">
            <div class="float-end">
                <p class="font-12 color-white opacity-60 mb-1">Sri Basavaraj Bommai and 2 more attending</p>
                <img class="shadow-xl rounded-xl float-end ms-n2" width="45" height="45"
                    src="https://bcare.org.in//public/uploads/events/637cad87039c3202211221107511BasavarajBommai.jpg">
                <img class="shadow-xl rounded-xl float-end ms-n2" width="45" height="45"
                    src="https://bcare.org.in//public/uploads/events/637cad8703a5c202211221107512ravi.jfif">
                <img class="shadow-xl rounded-xl float-end ms-n2" width="45" height="45"
                    src="https://bcare.org.in//public/uploads/events/637cad8703aee202211221107513Tejasvi_Surya.jpg">
            </div>
        </div>
        <div class="card-overlay bg-highlight opacity-90"></div>
    </div>

    <div class="card preload-img mt-4" data-src="https://bcare.org.in/public/images/pictures/20s.jpg">
    <div class="card-body">
        <h4 class="color-white text-center">ಅಂಕಿ ಅಂಶಗಳು</h4>
        <div class="card card-style ms-0 me-0 bg-theme">
            <div class="row m-0 py-3">
                @foreach($schemes as $scheme)
                    <div class="col-6 d-flex flex-column align-items-center mb-4">
                        <img class="rounded-circle object-cover" width="60" height="60"
                             src="{{ Storage::url($scheme->image) }}" 
                             alt="{{ $scheme->title }}">
                        
                        <h5 class="color-theme text-center font-13 mt-2">
                            {{ $scheme->title }}<br>
                            <span class="font-700 color-highlight">{{ $scheme->count }}</span>
                        </h5>
                    </div>
                @endforeach

                @if($schemes->isEmpty())
                    <div class="col-12 text-center py-3">
                        <p>ಯಾವುದೇ ಅಂಕಿ ಅಂಶಗಳು ಲಭ್ಯವಿಲ್ಲ.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-overlay bg-highlight opacity-90"></div>
</div>
    <div class="card card-style mt-4">
        <div class="content text-center">
            <h2>ಬಸವನಗುಡಿಯ ಪ್ರಸಿದ್ಧ ಕಾರ್ಯಕ್ರಮಗಳು</h2>
        </div>
        <div class="divider divider-small mb-3 bg-highlight"></div>
        <div class="content">
            @foreach ($abouts as $about)
                <div class="d-flex mb-4">
                    <img src="{{ Storage::url($about->image) }}" class="icon-80 me-3 rounded-s object-cover"
                        alt="{{ $about->title }}">

                    <div>
                        <h5>{{ $about->title }}</h5>

                        <p>{{ Str::limit($about->content, 100) }}</p>
                    </div>
                </div>
            @endforeach

            @if ($abouts->isEmpty())
                <p class="text-center">ಯಾವುದೇ ಕಾರ್ಯಕ್ರಮಗಳು ಲಭ್ಯವಿಲ್ಲ.</p>
            @endif
        </div>
    </div>

    <div class="card card-style mt-4 shadow-l" data-card-height="150">
        <div class="card-center ps-3 pe-3 text-center">
            @if ($contents->count() > 0)
                <h4 class="color-white">{{ $contents->first()->title }}</h4>

                <p class="color-white opacity-60">
                    {{ $contents->first()->content }}
                </p>
            @else
                <h4 class="color-white">ಸುಭಾಷಿತ !</h4>
                <p class="color-white opacity-60">ನಿನ್ನನ್ನು ಪೀಡಿಸುವ ಸಂಕಟಗಳನ್ನು ನಗುನಗುತ್ತಾ ನಾಶಪಡಿಸು.— ಸ್ವಾಮಿ ವಿವೇಕಾನಂದ.</p>
            @endif
        </div>
        <div class="card-overlay bg-highlight opacity-90"></div>
    </div>
    <div class="content mb-2">
        <h5 class="float-start font-16 font-500">ಲಭ್ಯವಿರುವ ಸೇವೆಗಳು / ಯೋಜನೆಗಳು</h5>
        <a class="float-end font-12 color-highlight mt-n1" href="#">ಎಲ್ಲವನ್ನೂ ವೀಕ್ಷಿಸಿ</a>
        <div class="clearfix"></div>
    </div>

    <div class="splide double-slider visible-slider" id="double-slider-3">
        <div class="splide__track">
            <div class="splide__list">
                @foreach ($services as $service)
                    <div class="splide__slide ps-3">
                        <div class="bg-theme rounded-m shadow-m text-center" style="height: 215px;">
                            <img class="rounded-circle mt-4 mb-2 object-cover" width="90" height="90"
                                src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}">

                            <h5 class="font-16">{{ $service->title }}</h5>

                            <p class="line-height-s font-11 px-2">
                                {{ Str::limit($service->content, 45) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection
