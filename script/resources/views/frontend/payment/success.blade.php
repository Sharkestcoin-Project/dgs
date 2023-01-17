@extends('layouts.frontend.product')

@section('title', $productOrder->product->name)

@section('content')
    <!-- Single Product Page Area -->
    <div class="single-product-page-area try-demo">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-md-8 col-lg-4">
                    <div class="single-product-area mb-50">
                        <div class="product-img">
                            <img src="{{ asset($productOrder->product->cover) }}" alt="">
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
                                <span>
                                    @php
                                        $description = $productOrder->product->description;
                                            if (strlen($description) > 100) {
                                                 $description = substr($description , 0, 100);

                                                 $description = substr($description,0, strrpos($description,' '));

                                                 echo $description = $description." <a class='text-secondary has-read-more' href='#'>Read More...</a>";
                                             }
                                    @endphp
                                </span>
                                <span class="full-text d-none">
                                    {{ $productOrder->product->description }}
                                </span>
                                <p>
                                    <i class="fas fa-file-download"></i>
                                    {{ __(':type File', ['type' => optional($productOrder->product)->mimeType]) }} –
                                    @if ($productOrder->product->meta['direct_url'] ?? false)
                                        {{ __('LINK') }}
                                    @else
                                        {{ human_filesize(optional($productOrder->product)->size) }}
                                    @endif
                                </p>
                            </div>
                            @if ($productOrder->product->file)
                            <a href="{{ route('download.start', $productOrder->token) }}" class="btn hero-btn d-block w-100" download>
                                {{ __('Download') }}
                            </a>
                            @else
                            <a target="_blank" href="{{ $productOrder->product->meta['direct_url'] }}" class="btn hero-btn d-block w-100">
                                {{ __('Download') }}
                            </a>
                            @endif
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
@endsection
