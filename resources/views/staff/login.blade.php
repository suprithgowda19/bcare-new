<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ravi Subramanya - Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

    <link rel="manifest" href="{{ asset('pwa/_manifest.json') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('pwa/app/icons/icon-192x192.png') }}">
    <link rel="icon" href="{{ asset('pwa/favicon.ico') }}" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/fonts/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pwa/styles/style.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">

    <style>
        .page-content { padding-bottom: 0px !important; }
        #page { background-color: #f0f2f5; }
        .s-alrt { z-index: 99; }
    </style>
</head>

<body class="theme-light" data-highlight="orange">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <div class="header header-fixed header-auto-show header-logo-app">
            <a href="#" class="header-title">ನಮ್ಮ ಬಸವನಗುಡಿ</a>
            <a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
        </div>

        <div class="page-content">

            <div class="page-title page-title-small">
                <div class="text-center">
                    <h2>ಬಿ-ಕೇರ್ / B-Care </h2>
                    <span class="color-white"> <strong> ಸಾರ್ವಜನಿಕ ಸಂಪರ್ಕ / Connecting Public </strong></span>
                </div>
            </div>

            <div class="card header-card shape-rounded" data-card-height="150">
                <div class="card-overlay bg-highlight opacity-95"></div>
                <div class="card-overlay dark-mode-tint"></div>
                <div class="card-bg preload-img" data-src="{{ asset('pwa/images/pictures/20s.jpg') }}"></div>
            </div>

            <div class="card card-style">
                <div class="content mt-2 mb-0">
                    <form method="POST" action="#">
                        @csrf 
                        <div class="d-flex flex-column gap-1 align-items-center mb-2 mt-2">
                            <h2>ಲಾಗಿನ್</h2>
                        </div>

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-user"></i>
                            <input type="tel" class="form-control validate-name" id="userPhone" placeholder="ಮೊಬೈಲ್ ಸಂಖ್ಯೆ" name="phone" required>
                            <label for="userPhone" class="color-blue-dark font-10 mt-1">Phone</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(ಅಗತ್ಯವಿದೆ)</em>
                        </div>

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control validate-password" id="userPass" placeholder="ಸಂಕೇತ ಪದ" name="password" required>
                            <label for="userPass" class="color-blue-dark font-10 mt-1">Password</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(ಅಗತ್ಯವಿದೆ)</em>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-m mt-4 mb-4 btn-full bg-green-dark rounded-sm text-uppercase font-900 w-100">
                                ಲಾಗಿನ್
                            </button>
                        </div>
                    </form>

                    <div class="divider mt-4 mb-3"></div>
                </div>
            </div>

            <div class="footer mb-80 text-center">
                @include('partials.staff.footer')
            </div>

        </div>

        <div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" 
             data-menu-width="260" 
             data-menu-load="#" 
             data-menu-active="nav-welcome" 
             data-menu-effect="menu-over"> 
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('pwa/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pwa/scripts/custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Auto-hide alerts
            $(".s-alrt").fadeTo(2000, 500).fadeOut(500, function() {
                $(this).remove();
            });
        });
    </script>

</body>
</html>