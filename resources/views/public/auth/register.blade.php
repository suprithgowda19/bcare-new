<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>ಬಿ-ಕೇರ್ | ನೋಂದಣಿ</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/fonts/css/fontawesome-all.min.css') }}">
    
    <style>
        .custom-btn {
            background: #e25841;
            color: white !important;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
        }
        .error-text {
            color: #ff3b30;
            font-size: 11px;
            font-weight: 600;
            margin-left: 45px;
            display: block;
            margin-top: -15px;
            margin-bottom: 10px;
        }
    </style>
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
                <div class="content mb-0 mt-1">
                    
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        
                        <div class="d-flex flex-column align-items-center gap-1 mt-2 mb-2">
                            <h2 class="font-700">ನೋಂದಣಿ (Registration)</h2>
                        </div>

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-user"></i>
                            <input type="text" class="form-control" id="name" placeholder="ಹೆಸರು (Name)" 
                                   name="name" value="{{ old('name') }}" required>
                            <label for="name" class="color-blue-dark font-10 mt-1">Full Name</label>
                        </div>
                        @error('name') <span class="error-text">{{ $message }}</span> @enderror

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-phone"></i>
                            <input type="tel" class="form-control" id="phone" placeholder="ಮೊಬೈಲ್ ಸಂಖ್ಯೆ (Mobile)" 
                                   name="phone" value="{{ old('phone') }}" required>
                            <label for="phone" class="color-blue-dark font-10 mt-1">Mobile Number</label>
                        </div>
                        @error('phone') <span class="error-text">{{ $message }}</span> @enderror

                        <div class="input-style no-borders has-icon validate-field mb-4 mt-2">
                            <i class="fa fa-at"></i>
                            <input type="email" class="form-control" id="email" placeholder="ಇ-ಮೇಲ್ ವಿಳಾಸ (Email)" 
                                   name="email" value="{{ old('email') }}" required>
                            <label for="email" class="color-blue-dark font-10 mt-1">Email Address</label>
                        </div>
                        @error('email') <span class="error-text">{{ $message }}</span> @enderror

                        <div class="input-style no-borders has-icon validate-field mb-4 mt-2">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="ಸಂಕೇತ ಪದವನ್ನು ರಚಿಸಿ (Password)" required>
                            <label for="password" class="color-blue-dark font-10 mt-1">Create Password</label>
                        </div>
                        @error('password') <span class="error-text">{{ $message }}</span> @enderror

                        <div class="input-style no-borders has-icon validate-field mb-4 mt-2">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control" id="password_confirmation" 
                                   name="password_confirmation" placeholder="ಸಂಕೇತ ಪದವನ್ನು ಖಚಿತಪಡಿಸಿ" required>
                            <label for="password_confirmation" class="color-blue-dark font-10 mt-1">Confirm Password</label>
                        </div>

                        <div class="d-flex flex-column align-items-center">
                            <input type="submit" 
                                   class="btn btn-m btn-full rounded-sm shadow-l bg-green-dark text-uppercase font-900 mt-4 w-100" 
                                   value="ಖಾತೆ ತೆರೆ (Register Now)">
                        </div>

                    </form>

                    <div class="divider mt-4 mb-3"></div>

                    <div class="d-flex pb-4">
                        <div class="w-100 font-11 color-theme opacity-60 text-center">
                            <a href="{{ route('public.login') }}" class="custom-btn shadow-xl">ಈಗಾಗಲೇ ನೋಂದಾಯಿಸಲಾಗಿದೆ? (Login)</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" data-menu-width="260" 
             data-menu-load="menu-main.html" data-menu-active="nav-welcome" data-menu-effect="menu-over">
        </div>

    </div>

    <script type="text/javascript" src="{{ asset('pwa/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pwa/scripts/custom.js') }}"></script>
</body>
</html>