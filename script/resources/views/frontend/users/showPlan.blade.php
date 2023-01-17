<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="@yield('meta_keywords', config('app.name'))">
    <meta name="description" content="@yield('meta_description', config('app.name'))">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ $plan->name }} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ get_option('logo_setting')['favicon'] ?? null }}">

    <!-- Import css File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/profile.css') }}">
</head>
@include('layouts.frontend.partials.preloader')
<div class="container profile-wrapper">
    <div class="row justify-content-center">
        <!-- Single Product -->
        <div class="col-md-6 col-lg-4">
            <div class="single-product-area mb-50">
                <div class="product-img">
                    <img src="{{ asset($plan->cover) }}" alt="">
                    <div class="price-tag">
                        <h5>{{ currency_format($plan->price, 'icon', $plan->currency->symbol) }}</h5>
                        <span class="video-sonar"></span>
                    </div>
                </div>
                <div class="product-details-area">
                    <a href="javascript:void(0)">
                        <h5>{{ $plan->name }}</h5>
                    </a>
                    <div class="modal-body-header d-flex align-items-center">
                        <div class="modal-logo">
                            <img src="{{ $plan->user->avatar ?? get_gravatar($plan->user->email) }}" alt="">
                        </div>
                        <span>{{ $plan->user->name }}</span>
                    </div>
                    <div class="product-desc">
                        <span>
                            @php
                                $description = $plan->description;
                                if (strlen($description) > 100) {
                                    $description = substr($description, 0, 100);

                                    $description = substr($description, 0, strrpos($description, ' '));

                                    echo $description = $description . " <a class='text-secondary has-read-more' href='#'>Read More...</a>";
                                } else {
                                    echo $description;
                                }
                            @endphp
                        </span>
                        <span class="full-text d-none">
                            {{ $plan->description }}
                        </span>
                    </div>


                    <ul class="list-group list-group-flush">
                        @foreach ($plan->features ?? [] as $feature)
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-check"></i>
                                {{ $feature['title'] }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="button-area text-center mt-30 mb-3">
                        <!-- Button -->
                        <button type="button" class="btn hero-btn d-block w-100 subscription-select"
                            data-plan="{{ $plan->id }}"
                            data-url="{{ route('user.get-plan', [$user->username, $plan->id]) }}">
                            {{ __('Subscribe') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="subscription-modal-body">

        </div>
    </div>
</div>
<body>

<!-- **** All JS Files ***** -->
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<!-- Custom Js -->
<script src="{{ asset('frontend/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('frontend/js/main-menu.js') }}"></script>
<!-- Active -->
<script src="{{ asset('frontend/js/default-assets/active.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>

<script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/js/custom.js') }}"></script>
<script src="{{ asset('admin/custom/form.js') }}"></script>
<script src="{{ asset('frontend/js/subscription.js') }}"></script>
</body>
</html>
