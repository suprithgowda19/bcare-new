<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

    <title>@yield('title', 'Azures')</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('pwa/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('pwa/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('pwa/fonts/css/fontawesome-all.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap" rel="stylesheet">

    {{-- PWA --}}
    <link rel="manifest" href="{{ asset('pwa/_manifest.json') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('pwa/app/icons/icon-192x192.png') }}">

    @stack('styles')
</head>

<body class="theme-light">

{{-- Preloader --}}
<div id="preloader">
    <div class="spinner-border color-highlight" role="status"></div>
</div>

<div id="page">

    {{-- Top Navbar --}}
    @include('partials.staff.navbar')

    {{-- Sidebar Menu --}}
    <div id="menu-main"
         class="menu menu-box-right menu-box-detached rounded-m"
         data-menu-width="260"
         data-menu-effect="menu-over">
        @include('partials.staff.sidebar')
    </div>

    {{-- Main Page Content --}}
    <div class="page-content mx-3">
        @yield('content')
        @include('partials.staff.media-links')
    </div>

    {{-- Footer Bar --}}
    <div class="footer fixed-bottom">
        @include('partials.staff.footer')
    </div>

</div>

{{-- Core Scripts --}}
<script src="{{ asset('pwa/scripts/bootstrap.min.js') }}"></script>
<script src="{{ asset('pwa/scripts/custom.js') }}"></script>

{{-- Feather Icons --}}
<script src="https://unpkg.com/feather-icons"></script>

{{-- ✅ REQUIRED: Re-init for PWA / AJAX navigation --}}
<script>
    function reInitUI() {

        // Feather icons (navbar, footer-bar, menus)
        if (window.feather) {
            feather.replace();
        }

        // Lazy images / backgrounds (preload-img)
        document.querySelectorAll('.preload-img').forEach(el => {
            const src = el.getAttribute('data-src');
            if (!src) return;

            if (el.tagName === 'IMG') {
                if (!el.getAttribute('src')) {
                    el.setAttribute('src', src);
                }
            } else {
                el.style.backgroundImage = `url('${src}')`;
                el.style.backgroundSize = 'cover';
                el.style.backgroundPosition = 'center';
            }
        });
    }

    // Initial load
    document.addEventListener('DOMContentLoaded', reInitUI);

    // Back / forward cache
    window.addEventListener('pageshow', reInitUI);

    // PWA internal navigation fallback
    setTimeout(reInitUI, 400);
</script>

@stack('scripts')

</body>
</html>
