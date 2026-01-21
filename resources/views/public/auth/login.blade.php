<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>ಬಿ-ಕೇರ್ | ಲಾಗಿನ್</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/fonts/css/fontawesome-all.min.css') }}">
    
    <style>
        .error-text { color: #ff3b30; font-size: 11px; font-weight: 600; margin-left: 45px; display: block; margin-top: -15px; margin-bottom: 10px; }
        .custom-btn { background: #e25841; color: white !important; padding: 10px 20px; border-radius: 10px; text-decoration: none; }
    </style>
</head>

<body class="theme-light">
    <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>

    <div id="page">
        <div class="page-content">
            <div class="page-title page-title-large text-center">
                <h2 class="mb-2 mt-6 color-white">ಬಿ-ಕೇರ್ / B-Care</h2>
                <p class="mb-2 color-white">ಸಾರ್ವಜನಿಕ ಲಾಗಿನ್ / Citizen Login</p>
            </div>

            <div class="card header-card shape-rounded" data-card-height="210">
                <div class="card-overlay bg-highlight opacity-95"></div>
                <div class="card-bg preload-img" data-src="{{ asset('pwa/images/pictures/20s.jpg') }}"></div>
            </div>

            <div class="card card-style">
                <div class="content mb-0 mt-1">
                    <form method="POST" action="{{ route('login.auth') }}">
                        @csrf
                        <div class="d-flex flex-column align-items-center mb-4">
                            <h2 class="font-700">ಪ್ರವೇಶಿಸಿ (Login)</h2>
                        </div>

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-phone"></i>
                            <input type="tel" name="phone" class="form-control" placeholder="ಮೊಬೈಲ್ ಸಂಖ್ಯೆ" value="{{ old('phone') }}" required>
                            <label class="color-blue-dark font-10">Mobile Number</label>
                        </div>
                        @error('phone') <span class="error-text">{{ $message }}</span> @enderror

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password" class="form-control" placeholder="ಸಂಕೇತ ಪದ" required>
                            <label class="color-blue-dark font-10">Password</label>
                        </div>
                        @error('password') <span class="error-text">{{ $message }}</span> @enderror

                        <button type="submit" class="btn btn-m btn-full rounded-sm shadow-l bg-green-dark text-uppercase font-900 mt-4 w-100">ಲಾಗಿನ್</button>
                    </form>

                    <div class="divider mt-4 mb-3"></div>
                    <div class="text-center pb-4">
                        <a href="{{ route('public.register') }}" class="font-12 color-theme opacity-60">ಖಾತೆ ಇಲ್ಲವೇ? ಇಲ್ಲಿ ನೋಂದಾಯಿಸಿ.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('pwa/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pwa/scripts/custom.js') }}"></script>
</body>
</html>