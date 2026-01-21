@extends('layouts.public')

@section('title', 'ಮುಖಪುಟ - Ravi Subramanya')

@section('content')
 
    <div class="splide single-slider slider-no-arrows slider-no-dots homepage-slider" id="single-slider-1">
        <div class="splide__track">
            <div class="splide__list">
                <div class="splide__slide">
                    <div class="card rounded-l mx-2 text-center shadow-l" data-card-height="320"
                        style="background-image: url({{ asset('pwa/images/banner2.jpg') }}); height: 320px;">
                        <div class="card-bottom">
                            <h1 class="font-24 font-700">ಕಡಲೆಕಾಯಿ ಪರಿಷೆ</h1>
                            <p class="boxed-text-xl">ಕಡಲೆಕಾಯಿ ಪರಿಷೆ, ಬಸವನಗುಡಿ</p>
                        </div>
                        <div class="card-overlay bg-gradient-fade"></div>
                    </div>
                </div>
                <div class="splide__slide">
                    <div class="card rounded-l mx-2 text-center shadow-l" data-card-height="320"
                        style="background-image: url({{ asset('pwa/images/banner1.jpg') }}); height: 320px;">
                        <div class="card-bottom">
                            <h1 class="font-24 font-700">ಅಂತರಾಷ್ಟ್ರೀಯ ಯೋಗ ದಿನ</h1>
                            <p class="boxed-text-xl">ಅಂತರಾಷ್ಟ್ರೀಯ ಯೋಗ ದಿನ!, ಜೂನ್ 21</p>
                        </div>
                        <div class="card-overlay bg-gradient-fade"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-0">
        <div class="row">
            <div class="col-6">
                <a href="#" class="btn btn-full btn-m rounded-s text-uppercase font-900 shadow-xl bg-highlight">ದೂರನ್ನು ನೋಂದಾಯಿಸಿ</a>
            </div>
            <div class="col-6">
                <a href="#" class="btn btn-full btn-m rounded-s text-uppercase font-900 shadow-xl bg-highlight">ನನ್ನ ದೂರುಗಳು</a>
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
                <div class="splide__slide ps-3">
                    <div class="bg-theme pb-3 rounded-m shadow-l text-center overflow-hidden">
                        <div data-card-height="150" class="card mb-2" style="background-image: url({{ asset('pwa/images/prasidda1.jpg') }}); height: 150px;">
                            <h5 class="card-bottom color-white mb-2">ಕಡಲೆಕಾಯಿ ಪರಿಷೆ</h5>
                            <div class="card-overlay bg-gradient"></div>
                        </div>
                        <p class="mb-3 ps-2 pe-2 pt-2 font-12">ಬಸವನಗುಡಿ ಕಡಲೆಕಾಯಿ ಪರಿಷೆಗೆ ಈ ಬಾರಿ ದಾಖಲೆಯ 8 ಲಕ್ಷ ಮಂದಿ ಭೇಟಿ</p>
                    </div>
                </div>
                <div class="splide__slide ps-3">
                    <div class="bg-theme pb-3 rounded-m shadow-l text-center overflow-hidden">
                        <div data-card-height="150" class="card mb-2" style="background-image: url({{ asset('pwa/images/new2.jfif') }}); height: 150px;">
                            <h5 class="card-bottom color-white mb-2">ಮಹಿಳಾ ಕ್ರೀಡಾ ಕ್ಲಬ್</h5>
                            <div class="card-overlay bg-gradient"></div>
                        </div>
                        <p class="mb-3 ps-2 pe-2 pt-2 font-12">ಒಟ್ಟಾಗಿ ನಾವು ಜನರು ಯಾವುದೇ ಏಕಕ್ಕಿಂತ ಹೆಚ್ಚಿನದನ್ನು ಸಾಧಿಸುತ್ತೇವೆ.</p>
                    </div>
                </div>
                <div class="splide__slide ps-3">
                    <div class="bg-theme pb-3 rounded-m shadow-l text-center overflow-hidden">
                        <div data-card-height="150" class="card mb-2" style="background-image: url({{ asset('pwa/images/news3.jpg') }}); height: 150px;">
                            <h5 class="card-bottom color-white mb-2">ಪೊಲೀಸ್ ಕಾರ್ಯಾಚರಣೆ</h5>
                            <div class="card-overlay bg-gradient"></div>
                        </div>
                        <p class="mb-3 ps-2 pe-2 pt-2 font-12">ಬಸವನಗುಡಿ ಪೊಲೀಸರು ಒಂದೇ ದಿನದಲ್ಲಿ ಕಳ್ಳತನದ ಆರೋಪಿಯನ್ನು ಪತ್ತೆ ಹಚ್ಚಿದ್ದಾರೆ.</p>
                    </div>
                </div>
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
                <div class="splide__slide ps-3">
                    <div class="bg-theme rounded-m shadow-m text-center h-240 mb-4">
                        <img class="rounded-circle mt-4 mb-4" width="90" height="90" src="{{ asset('pwa/images/act1.jpg') }}">
                        <h5 class="font-16">ಉಚಿತ ಶಿಕ್ಷಣ</h5>
                        <p class="line-height-s font-11 pb-4">ಉಚಿತ ಶಿಕ್ಷಣವು ಮುಖ್ಯವಾಗಿದೆ ಏಕೆಂದರೆ ಇದು ದೇಶದ .</p>
                    </div>
                </div>
                <div class="splide__slide ps-3">
                    <div class="bg-theme rounded-m shadow-m text-center h-240 mb-4">
                        <img class="rounded-circle mt-4 mb-4" width="90" height="90" src="{{ asset('pwa/images/act2.jpg') }}">
                        <h5 class="font-16">ಜನೌಷಧಿ ಕೇಂದ್ರಗಳು</h5>
                        <p class="line-height-s font-11 pb-4">ಜನೌಷಧಿ ಉಪಕ್ರಮವು ಕಡಿಮೆ ಬೆಲೆಯಲ್ಲಿ ಲಭ್ಯವಿರುವ ಆದರೆ</p>
                    </div>
                </div>
                <div class="splide__slide ps-3">
                    <div class="bg-theme rounded-m shadow-m text-center h-240 mb-4">
                        <img class="rounded-circle mt-4 mb-4" width="90" height="90" src="{{ asset('pwa/images/act3.jpg') }}">
                        <h5 class="font-16">ಉಚಿತ ಪಡಿತರ</h5>
                        <p class="line-height-s font-11 pb-4">ಉಚಿತ ಪಡಿತರವನ್ನು ಒದಗಿಸುವುದು ಭಾರತ ಸರ್ಕಾರವು ಕೈಗೊಂಡ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-20 mb-4">
        <div class="card-body">
            <h2 class="color-white font-600 mb-4 pt-3 text-center">ಬಸವನಗುಡಿ ನವೀಕರಣಗಳು</h2>
            <div class="splide3 splide single-slider slider-no-arrows slider-no-dots visible-slider" id="double-slider-6">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div class="card card-style">
                                <img src="https://bcare.org.in//public/uploads/updates/20221115054847park insp.jpg" class="img-fluid" style="height: 276px; object-fit: cover;">
                                <div class="d-flex mt-n2 ms-3"><span class="badge bg-red-dark">ಪಾರ್ಕ್</span></div>
                                <div class="content"><h4>ಪಾರ್ಕ್ ನಿರ...</h4><p>ಉದ್ಯಾನವನಗಳು ಸಾಮಾನ್ಯವಾಗಿ ಸ್ಥಳೀಯ ಸರ್ಕಾರದ ಒಡೆತನದಲ್ಲಿ...</p></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card card-style">
                                <img src="https://bcare.org.in//public/uploads/updates/20221115053130work inspection.jfif" class="img-fluid" style="height: 276px; object-fit: cover;">
                                <div class="d-flex mt-n2 ms-3"><span class="badge bg-red-dark">ರಸ್ತೆ</span></div>
                                <div class="content"><h4>ರಸ್ತೆ ಕೆಲಸ...</h4><p>ಈ ನಿಟ್ಟಿನಲ್ಲಿ ರಸ್ತೆ ನಿರ್ವಹಣೆ ಅತ್ಯಗತ್ಯ...</p></div>
                            </div>
                        </div>
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
                <a href="#" class="bg-white color-black btn btn-s rounded-xl font-900 font-11">ಕಾರ್ಯಕ್ರಮ ಸೇರಿಕೊಳ್ಳಿ</a>
            </div>
            <p class="color-white ms-3 font-10 opacity-80 mb-n1"><i class="far fa-calendar"></i> November 30 <i class="ms-4 far fa-clock"></i> 12:00 am</p>
            <p class="color-white ms-3 font-10 opacity-80"><i class="fa fa-map-marker-alt"></i> ಬಸವನಗುಡಿ</p>
        </div>
        <div class="card-bottom pb-3 pe-4">
            <div class="float-end">
                <p class="font-12 color-white opacity-60 mb-1">Sri Basavaraj Bommai and 2 more attending</p>
                <img class="shadow-xl rounded-xl float-end ms-n2" width="45" height="45" src="https://bcare.org.in//public/uploads/events/637cad87039c3202211221107511BasavarajBommai.jpg">
                <img class="shadow-xl rounded-xl float-end ms-n2" width="45" height="45" src="https://bcare.org.in//public/uploads/events/637cad8703a5c202211221107512ravi.jfif">
                <img class="shadow-xl rounded-xl float-end ms-n2" width="45" height="45" src="https://bcare.org.in//public/uploads/events/637cad8703aee202211221107513Tejasvi_Surya.jpg">
            </div>
        </div>
        <div class="card-overlay bg-highlight opacity-90"></div>
    </div>

    <div class="card preload-img mt-4" data-src="https://bcare.org.in/public/images/pictures/20s.jpg">
        <div class="card-body">
            <h4 class="color-white text-center">ಅಂಕಿ ಅಂಶಗಳು</h4>
            <div class="card card-style ms-0 me-0 bg-theme">
                <div class="row m-3">
                    <div class="col-6 d-flex flex-column align-items-center">
                        <img class="rounded-circle" width="60" height="60" src="{{ asset('pwa/images/count1.jfif') }}">
                        <h5 class="color-theme text-center font-13 mt-2">ಶೈಕ್ಷಣಿಕ ಸಂಸ್ಥೆಗಳು<br>18</h5>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-center">
                        <img class="rounded-circle" width="60" height="60" src="{{ asset('pwa/images/count2.png') }}">
                        <h5 class="color-theme text-center font-13 mt-2">ಆರೋಗ್ಯ ಉಪಕ್ರಮಗಳು<br>16</h5>
                    </div>
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
            <div class="d-flex mb-4">
                <img src="{{ asset('pwa/images/prasidda1.jpg') }}" class="icon-80 me-3 rounded-s">
                <div><h5>ಕಡಲೇಕಾಯಿ ಪರಿಷೆ</h5><p>ಭಾರತವು ನಾವು ಎಲ್ಲವನ್ನೂ ಮತ್ತು ಯಾವುದನ್ನಾದರೂ ಆಚರಿಸುವ ಭೂಮಿಯಾಗಿದೆ...</p></div>
            </div>
            <div class="d-flex mb-4">
                <img src="{{ asset('pwa/images/prasid2.jpg') }}" class="icon-80 me-3 rounded-s">
                <div><h5>ಗಣೇಶ ಉತ್ಸವ</h5><p>60ನೇ ಬೆಂಗಳೂರು ಗಣೇಶ ಉತ್ಸವವು ದೇಶದ ಕೆಲವು ಅತ್ಯುತ್ತಮ ಕಲಾವಿದರಿಂದ...</p></div>
            </div>
        </div>
    </div>

    <div class="card card-style mt-4 shadow-l" data-card-height="150">
        <div class="card-center ps-3 pe-3 text-center">
            <h4 class="color-white">ಸುಭಾಷಿತ !</h4>
            <p class="color-white opacity-60">ನಿನ್ನನ್ನು ಪೀಡಿಸುವ ಸಂಕಟಗಳನ್ನು ನಗುನಗುತ್ತಾ ನಾಶಪಡಿಸು.— ಸ್ವಾಮಿ ವಿವೇಕಾನಂದ.</p>
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
                <div class="splide__slide ps-3">
                    <div class="bg-theme rounded-m shadow-m text-center" style="height: 215px;">
                        <img class="rounded-circle mt-4 mb-2" width="90" height="90" src="{{ asset('pwa/images/sev4.jpg') }}">
                        <h5 class="font-16">ಮತದಾರ</h5>
                        <p class="line-height-s font-11">18 ವರ್ಷ ಮೇಲ್ಪಟ್ಟ ಪ್ರತಿಯೊಬ...</p>
                    </div>
                </div>
                <div class="splide__slide ps-3">
                    <div class="bg-theme rounded-m shadow-m text-center" style="height: 215px;">
                        <img class="rounded-circle mt-4 mb-2" width="90" height="90" src="{{ asset('pwa/images/sev5.jpg') }}">
                        <h5 class="font-16">ಪಿಂಚಣಿ</h5>
                        <p class="line-height-s font-11">ರಾಷ್ಟ್ರೀಯ ಪಿಂಚಣಿ ವ್ಯವಸ್ಥೆ...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="menu-install-pwa-android" class="menu menu-box-bottom menu-box-detached rounded-l" data-menu-height="350" data-menu-effect="menu-parallax">
        <div class="boxed-text-l mt-4 text-center">
            <img class="rounded-l mb-3" src="{{ asset('pwa/app/icons/icon-128x128.png') }}" width="90">
            <h4>Azures on your Home Screen</h4>
            <p>Install Azures on your home screen for quick access.</p>
            <a href="#" class="pwa-install btn btn-s rounded-s shadow-l bg-highlight mb-2">Add to Home Screen</a>
        </div>
    </div>

    <div id="menu-install-pwa-ios" class="menu menu-box-bottom menu-box-detached rounded-l" data-menu-height="320" data-menu-effect="menu-parallax">
        <div class="boxed-text-xl mt-4 text-center">
            <img class="rounded-l mb-3" src="{{ asset('pwa/app/icons/icon-128x128.png') }}" width="90">
            <h4>Azures on your Home Screen</h4>
            <p>Open your Safari menu and tap "Add to Home Screen".</p>
        </div>
    </div>
@endsection