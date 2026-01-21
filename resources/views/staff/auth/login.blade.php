<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>B-Care Staff Login</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/fonts/css/fontawesome-all.min.css') }}">
    
    <link rel="manifest" href="{{ asset('pwa/_manifest.json') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('pwa/app/icons/icon-192x192.png') }}">
</head>

<body class="theme-light" data-highlight="blue2">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
        <div class="page-content">

            <div class="page-title page-title-large text-center">
                <h2 class="mb-2 mt-6" style="color: white;">ಬಿ-ಕೇರ್ / B-Care</h2>
                <p class="mb-2" style="color: white;">ಸಾರ್ವಜನಿಕ ಸಂಪರ್ಕ / Connecting Public</p>
            </div>

            <div class="card header-card shape-rounded" data-card-height="210">
                <div class="card-overlay bg-highlight opacity-95"></div>
                <div class="card-overlay dark-mode-tint"></div>
                <div class="card-bg preload-img" data-src="{{ asset('pwa/images/pictures/20s.jpg') }}"></div>
            </div>

            <div class="card card-style">
                <div class="content mt-2 mb-0">
                    <div class="d-flex flex-column gap-1 align-items-center mb-2 mt-2">
                        <h2>ಲಾಗಿನ್ (Staff)</h2>
                    </div>

                    <form method="POST" action="{{ route('staff.login.submit') }}">
                        @csrf

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-user"></i>
                            <input type="email" name="email" class="form-control validate-name" id="form1a" placeholder="Email Address" value="{{ old('email') }}" required>
                            <label for="form1a" class="color-blue-dark font-10 mt-1">Email</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            @error('email')
                                <span class="color-red-dark font-11 mt-n2 d-block pb-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password" class="form-control validate-password" id="form3a" placeholder="ಸಂಕೇತ ಪದ" required>
                            <label for="form3a" class="color-blue-dark font-10 mt-1">Password</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            @error('password')
                                <span class="color-red-dark font-11 mt-n2 d-block pb-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <center>
                            <button type="submit" class="btn btn-m mt-4 mb-4 btn-full bg-green-dark rounded-sm text-uppercase font-900 w-100">
                                ಲಾಗಿನ್
                            </button>
                        </center>
                    </form>

                    <div class="divider mt-4 mb-3"></div>
                </div>
            </div>
        </div>
        @include('partials.staff.media-links')
    </div>

    

    <script type="text/javascript" src="{{ asset('pwa/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pwa/scripts/custom.js') }}"></script>
</body>
</html>