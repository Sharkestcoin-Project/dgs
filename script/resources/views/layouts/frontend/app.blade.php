<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
     {!! SEO::generate() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ get_option('logo_setting')['favicon'] ?? null }}">

    <!-- Import css File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/custom.css') }}">

    @yield('css')
    @stack('css')
</head>
@include('layouts.frontend.partials.preloader')
@include('layouts.frontend.partials.header')
@yield('content')
@include('layouts.frontend.partials.footer')
<body>

<!-- **** All JS Files ***** -->
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<!-- Custom Js -->
<script src="{{ asset('frontend/js/aos.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/js/main-menu.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>

<!-- Active -->
<script src="{{ asset('frontend/js/default-assets/active.js') }}"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>

@yield('script')
@stack('script')

@if(Session::has('success'))
    <script>
        Sweet('success', '{{ Session::get('success') }}');
    </script>
@endif

@if(Session::has('warning'))
    <script>
        Sweet('warning', '{{ Session::get('warning') }}');
    </script>
@endif

@if(Session::has('error'))
    <script>
        Sweet('error', '{{ Session::get('error') }}');
    </script>
@endif

@if(Request::has('trigger'))
    <script>
        $('#{{ Request::get('trigger') }}').trigger('click');
    </script>
@endif

</body>
</html>
