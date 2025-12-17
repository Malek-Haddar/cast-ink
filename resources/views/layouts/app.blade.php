<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- CSS assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>
    @includeIf('partials.header')

    <main>
        @yield('content')
    </main>

    @includeIf('partials.footer')
    @includeIf('partials.script')

    <!--<< All JS Plugins >>-->
    <!-- js Jquery start -->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <!-- js Bootstrap start -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- js Waypoints start -->
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <!-- js Magnific popup start -->
    <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>
    <!-- js Nice Select start -->
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <!-- js Swiper start -->
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <!-- js Aos Counterup start -->
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <!-- js Aos Animation start -->
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <!-- js Aos Tilt start -->
    <script src="{{ asset('assets/js/vanilla-tilt.min.js') }}"></script>
    <!-- js Phosphor Icon start -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- js Mian start -->
    <script src="assets/js/main.js"></script>
</body>
</html>