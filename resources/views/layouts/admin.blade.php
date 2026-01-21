<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Meta --}}
    <meta name="description" content="Zeta admin dashboard">
    <meta name="author" content="pixelstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title --}}
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('assets/images/newphotes/icon.jpg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/newphotes/icon.jpg') }}" type="image/x-icon">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    {{-- Core Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/scrollbar.css') }}">

    {{-- ✅ Bootstrap Icons (REQUIRED for bi-* icons) --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" id="color">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    {{-- Page-level CSS --}}
    @stack('css')
    @yield('external_css')

    {{-- Layout overrides --}}
    <style>
        .page-wrapper.compact-wrapper
        .page-body-wrapper
        div.sidebar-wrapper
        .sidebar-main
        .simplebar-offset {
            height: auto !important;
        }

        .nav-menus {
            display: flex;
            align-items: center;
        }

        .footer {
            margin-left: 0 !important;
        }

        @media (max-width: 1366px) and (min-width: 767px) {
            .page-wrapper.compact-wrapper
            .page-header
            .header-wrapper
            .nav-right {
                flex: 0 0 64%;
                max-width: 64%;
            }
        }

        @media (max-width: 767px) {
            .page-wrapper.compact-wrapper
            .page-header
            .header-wrapper
            .nav-right {
                margin-left: 0 !important;
            }
        }
    </style>

    @yield('internal_css')
</head>

<body>

{{-- Back to top --}}
<div class="tap-top">
    <i data-feather="chevrons-up"></i>
</div>

<div class="page-wrapper default-wrapper" id="pageWrapper">

    {{-- NAVBAR --}}
    @include('partials.admin.navbar')

    <div class="page-body-wrapper default-menu">

        {{-- SIDEBAR --}}
        @include('partials.admin.sidebar')

        <div class="page-body">

            {{-- PAGE HEADER --}}
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3>@yield('page_title')</h3>
                        </div>
                        <div class="col-12 col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i data-feather="home"></i></a>
                                </li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alerts --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            {{-- MAIN CONTENT --}}
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    @include('partials.admin.footer')
</div>

{{-- Core JS --}}
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>

{{-- ❗ BUG FIX: closing tag was broken --}}
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

{{-- Icons --}}
<script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>

{{-- Plugins --}}
<script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>

{{-- Theme --}}
<script src="{{ asset('assets/js/script.js') }}"></script>

{{-- Page-level JS --}}
@stack('scripts')
@yield('external_scripts')

{{-- Auto dismiss alerts --}}
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.transition = "all 0.4s ease";
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-10px)";
            setTimeout(() => alert.remove(), 400);
        });
    }, 5000);
</script>

@yield('internal_scripts')

</body>
</html>
