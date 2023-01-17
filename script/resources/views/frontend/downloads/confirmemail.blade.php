@extends('layouts.frontend.product')

@section('title', __('Confirm Your Email'))

@section('content')
    <!-- Single Product Page Area -->
    <div class="single-product-page-area confirm-download">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-md-8 col-lg-4">
                    <div class="single-product-area mb-50">
                        <div class="product-img">
                            <img src="{{ $productOrder->product->cover  }}" alt="">
                            <div class="price-tag">
                                <h5>{{ currency_format($productOrder->product->price, 'icon', $productOrder->product->currency->symbol) }}</h5>
                                <span class="video-sonar"></span>
                            </div>
                        </div>
                        <div class="product-details-area">
                            <h5>{{ $productOrder->product->name }}</h5>
                            <div class="modal-body-header d-flex align-items-center">
                                <div class="modal-logo">
                                    <img src="{{ $productOrder->product->user->avatar ?? get_gravatar($productOrder->product->user->email) }}" alt="">
                                </div>
                                <span>{{ $productOrder->product->user->name }}</span>
                            </div>
                            <div class="product-desc">
                                @include('frontend.partials.productdescription', ['product' => $productOrder->product])
                                <p>
                                    <i class="fas fa-file-download"></i>
                                    {{ __(':type File', ['type' => $productOrder->product->mimeType]) }} – {{ human_filesize($productOrder->product->size) }}
                                </p>
                            </div>
                            <form action="{{ route('download.resent', $productOrder->uuid) }}" method="POST" class="resentEmail">
                                @csrf

                                <div class="form__box mb-20">
                                    <input type="text" name="download_otp" id="download_otp" class="form__input" placeholder="{{ __('ENTER OTP') }}" required>
                                    <label for="download_otp" class="form__label">{{ __('ENTER OTP') }}</label>
                                    <div class="form__shadow"></div>
                                </div>

                                <div class="button-area text-center mt-30 mb-3">
                                    <!-- Button -->
                                    <button type="submit" class="btn hero-btn d-block w-100">{{ __('Send Link') }}</button>
                                </div>
                            </form>

                            <form action="{{ route('download.sendotp', $productOrder->uuid) }}" method="POST" class="resentEmail">
                                @csrf

                                <button type="submit" class="btn d-block w-100 text-primary">{{ __('SEND OPT') }}</button>
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
@endsection
