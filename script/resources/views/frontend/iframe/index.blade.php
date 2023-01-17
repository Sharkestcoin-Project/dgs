<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- Import css File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/new.css') }}">
</head>

    <div class="single-product-page-area try-demo">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-12">
                    <div class="single-modal-content">
                        <div class="modal-header try-demo">
                            <img width="100%" class="max-h-300" src="{{ asset($product->cover) }}" alt="">
                            <div class="price-tag">
                                <h5>
                                    <h5>{{ currency_format($product->price, 'icon', $product->currency->symbol) }}</h5>
                                </h5>
                                <span class="video-sonar"></span>
                            </div>

                        </div>
                        <div class="modal-body try-demo-form">
                            <h5>{{ $product->name }}</h5>
                            <div class="modal-body-header d-flex align-items-center">
                                <div class="modal-logo">
                                    <img src="{{ asset('frontend/img/bg-img/u-3.jpg') }}" alt="">
                                </div>
                                <span>{{ $product->user->meta['store_name'] ?? '' }}</span>
                            </div>
                            <p>{{ $product->description }}</p>
                            <a class="modal-btn" href="{{ route('products.show', $product->id) }}">{{ __('Read more') }} <i class="fas fa-chevron-right"></i></a>

                            <div class="product-desc">
                                <p>
                                    <i class="fas fa-file-download"></i>
                                    {{ __(':type File', ['type' => $product->mimeType]) }} – {{ human_filesize($product->size) }}
                                </p>
                            </div>

                            <div class="modal-form-area">
                                <form action="{{ route('iframe.order', $product->id) }}" method="GET" target="_blank" formtarget="_blank">
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
                            </div>
                        </div>
                        <!-- Payment Support -->
                        <div class="support-area p-3 d-flex justify-content-between align-items-center">
                            <p><i class="fas fa-unlock mr-2"></i> {{ __('Powered by') }} <a href="#">{{ $product->user->meta['store_name'] ?? '' }}</a></p>
                            <div class="support-img">
                                <img src="{{ asset('frontend/img/icons/2.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
