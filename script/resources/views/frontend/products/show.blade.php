<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="@yield('meta_keywords', config('app.name'))">
    <meta name="description" content="@yield('meta_description', config('app.name'))">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ $product->name }} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ get_option('logo_setting')['favicon'] ?? null }}">

    <!-- Import css File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/custom.css') }}">

    @yield('css')
    @stack('css')
</head>
@include('layouts.frontend.partials.preloader')
<div class="all-product-area section-padding-100-50">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Single Product -->
            <div class="col-md-6 col-lg-4">
                <div class="single-product-area mb-50">
                    <div class="product-img">
                        <img src="{{ $product->cover  }}" alt="">
                        <div class="price-tag">
                            <h5>{{ currency_format($product->price, 'icon', $product->currency->symbol) }}</h5>
                            <span class="video-sonar"></span>
                        </div>
                    </div>
                    <div class="product-details-area">
                        <h5>{{ $product->name }}</h5>
                        <div class="modal-body-header d-flex align-items-center">
                            <div class="modal-logo">
                                <img src="{{ $product->user->avatar ?? get_gravatar($product->user->email) }}" alt="">
                            </div>
                            <span>{{ $product->user->name }}</span>
                        </div>
                        <div class="product-desc">
                        <span>
                            @php
                                $description = $product->description;
                                    if (strlen($description) > 100) {
                                         $description = substr($description , 0, 100);

                                         $description = substr($description,0, strrpos($description,' '));

                                         echo $description = $description." <a class='text-secondary has-read-more' href='#'>Read More...</a>";
                                     }
                            @endphp
                            </span>
                                <span class="full-text d-none">
                                {{ $product->description }}
                            </span>
                            <p>
                                <i class="fas fa-file-download"></i>
                                {{ __(':type File', ['type' => $product->mimeType]) }} –
                                @if ($product->meta['direct_url'] ?? false)
                                    {{ __('LINK') }}
                                @else
                                    {{ human_filesize($product->size) }}
                                @endif
                            </p>
                        </div>
                        <form action="{{ route('order.index', $product->id) }}" method="POST">
                            @csrf

                            <div class="form__box mb-20">
                                <input type="text" name="name" id="name" class="form__input" placeholder="{{ __('Your Name') }}" min="5" required>
                                <label for="name" class="form__label">{{ __('Your Name') }}</label>
                                <div class="form__shadow"></div>
                            </div>

                            <div class="form__box mb-20">
                                <input type="email" name="email" id="email" class="form__input" placeholder="{{ __('Your Email') }}" required>
                                <label for="email" class="form__label">{{ __('Your Email') }}</label>
                                <div class="form__shadow"></div>
                            </div>

                            <div class="button-area text-center mt-30 mb-3">
                                <!-- Button -->
                                <button type="submit" class="btn hero-btn d-block w-100">{{ __('Pay') }}</button>
                            </div>
                        </form>
                        <div class="support-area d-flex justify-content-between align-items-center">
                            <p>
                                <i class="fas fa-unlock mr-2"></i>
                                {{ __('Powered by') }}
                                <a href="{{ config('app.url') }}">
                                    {{ config('app.name') }}
                                </a>
                            </p>
                            <div class="support-img">
                                <img src="{{ asset('frontend/img/icons/2.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
</body>
</html>
