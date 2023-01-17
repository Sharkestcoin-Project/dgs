@extends('layouts.frontend.product')

@section('title', $demo->title ?? null)

@section('content')
    <!-- Single Product Page Area -->
    <div class="single-product-page-area try-demo">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-md-8 col-lg-4">
                    <div class="single-product-area mb-50">
                        <div class="product-img">
                            <img src="{{ $demo->product_cover ?? null }}" alt="">
                        </div>
                        <div class="product-details-area">
                            <h5>{{ $demo->name ?? null }}</h5>
                            <div class="modal-body-header d-flex align-items-center">
                                <div class="modal-logo">
                                    <img src="{{ $demo->user_avatar ?? null }}" alt="">
                                </div>
                                <span>{{ $demo->user_name ?? null }}</span>
                            </div>
                            <div class="product-desc">
                                <span>
                                    @php
                                        $description = $demo->description;
                                            if (strlen($description) > 100) {
                                                 $description = substr($description , 0, 100);

                                                 $description = substr($description,0, strrpos($description,' '));

                                                 echo $description = $description." <a class='text-secondary has-read-more' href='#'>Read More...</a>";
                                             }
                                    @endphp
                                </span>
                                <span class="full-text d-none">
                                    {{ $demo->description }}
                                </span>
                                <p>
                                    <i class="fas fa-file-download"></i>
                                    {{ __(':type File', ['type' => $filetype]) }} – {{ human_filesize($filesize) }}
                                </p>
                            </div>
                            <a href="{{ route('demo.download', [$timestamp, $demo->file]) }}" class="btn hero-btn d-block w-100" >
                                {{ __('Download') }}
                            </a>
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
