<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ Config::get('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ get_option('logo_setting')->logo ?? null }}">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">

</head>
<body>

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="{{ isset($wrapperClass) ? $wrapperClass : 'col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2' }}">
                    <div class="login-brand">
                        <img src="{{ get_option('logo_setting', true)->logo ?? null }}" alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Register</h4></div>

                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; Stisla 2018
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('admin/plugins/jquery/jquery-3.6.0.min.js') }}"></script>

<script src="{{ asset('admin/plugins/popperjs/popper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/plugins/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plugins/selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('admin/plugins/select2/select2.min.js') }}"></script>


<!-- Template JS File -->
<script src="{{ asset('admin/js/scripts.js') }}"></script>

<script src="{{ asset('admin/js/main.js') }}"></script>
<script src="{{ asset('admin/js/custom.js') }}"></script>
<script src="{{ asset('admin/custom/form.js') }}"></script>

</body>
</html>
