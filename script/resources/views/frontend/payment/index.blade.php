@extends('layouts.frontend.product')

@section('title', __('Product'))

@section('content')
    @if($isSubscription)
        @include('frontend.payment.subscriptions.index')
    @else
    <!-- Single Product Page Area -->
    <div class="single-product-page-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-md-6 col-lg-6 gateways">
                    @include('frontend.payment.getGateways')
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="single-product-area">
                        <div class="product-img">
                            <img src="{{ asset($product->cover) }}" alt="">
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
                                    {{ __(':type File', ['type' => $product->mimeType]) }} – {{ human_filesize($product->size) }}
                                </p>
                            </div>
                            <form action="{{ route('order.validate-promo', $product->id) }}" method="POST" class="promoform">
                                @csrf
                                <div class="newsletter-form mb-4">
                                    <input class="form-control" type="text" name="code" id="code" placeholder="{{ __('Enter promo code') }}" value="{{ $promotion->code ?? null }}" @disabled(isset($promotion)) required>
                                    <button
                                        @class([
                                            'btn',
                                            'px-3',
                                            'basicbtn',
                                            'submit-btn',
                                            'btn-remove bg-danger' => isset($promotion),
                                        ])
                                        type="submit"
                                    >
                                        @if(isset($promotion))
                                            {{ __('Remove')}}
                                        @else
                                            {{ __('Apply')}}
                                        @endif
                                    </button>
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
    <!-- Single Product Page Area -->
    <input type="hidden" id="removePromoUrl" value="{{ route('order.remove-promo', $product->id) }}">
    @endif
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/js/payment.index.js') }}"></script>
@endpush
