@extends('layouts.backend.app')

@section('title', __('Headings'))

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="welcome-tab" data-toggle="tab" href="#welcome" role="tab" aria-controls="home" aria-selected="true">
                                {{ __('Welcome Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="feature-tab" data-toggle="tab" href="#feature" role="tab" aria-controls="feature" aria-selected="false">
                                {{ __('Feature Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">
                                {{ __('About Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="our-service-tab" data-toggle="tab" href="#our-service" role="tab" aria-controls="our-service" aria-selected="false">
                                {{ __('Our Service Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pricing-tab" data-toggle="tab" href="#pricing" role="tab" aria-controls="pricing" aria-selected="false">
                                {{ __('Pricing Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">
                                {{ __('Review Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="faq-tab" data-toggle="tab" href="#faq" role="tab" aria-controls="faq" aria-selected="false">
                                {{ __('Faq Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="latest-news-tab" data-toggle="tab" href="#latest-news" role="tab" aria-controls="latest-news" aria-selected="false">
                                {{ __('Latest News Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="call-to-action-tab" data-toggle="tab" href="#call-to-action" role="tab" aria-controls="call-to-action" aria-selected="false">
                                {{ __('Call To Action Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="trusted-by-tab" data-toggle="tab" href="#trusted-by" role="tab" aria-controls="trusted-by" aria-selected="false">
                                {{ __('Trusted By Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="trusted-partner-tab" data-toggle="tab" href="#trusted-partner" role="tab" aria-controls="trusted-partner" aria-selected="false">
                                {{ __('Trusted Partner Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="about-us-tab" data-toggle="tab" href="#about-us" role="tab" aria-controls="about-us" aria-selected="false">
                                {{ __('About Us Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                {{ __('Contact Section') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab" data-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="false">
                                {{ __('Product Section') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-8">
            <div class="tab-content no-padding" id="myTab2Content">
                <div class="tab-pane fade show active" id="welcome" role="tabpanel" aria-labelledby="welcome-tab">
                    @include('admin.settings.website.heading.welcome')
                </div>

                <div class="tab-pane fade" id="feature" role="tabpanel" aria-labelledby="feature-tab">
                    @include('admin.settings.website.heading.feature')
                </div>

                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                    @include('admin.settings.website.heading.about')
                </div>

                <div class="tab-pane fade" id="our-service" role="tabpanel" aria-labelledby="our-service-tab">
                    @include('admin.settings.website.heading.ourservice')
                </div>

                <div class="tab-pane fade" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                    @include('admin.settings.website.heading.pricing')
                </div>

                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                    @include('admin.settings.website.heading.review')
                </div>

                <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                    @include('admin.settings.website.heading.faq')
                </div>

                <div class="tab-pane fade" id="latest-news" role="tabpanel" aria-labelledby="latest-news-tab">
                    @include('admin.settings.website.heading.latestnews')
                </div>

                <div class="tab-pane fade" id="call-to-action" role="tabpanel" aria-labelledby="call-to-action-tab">
                    @include('admin.settings.website.heading.calltoaction')
                </div>

                <div class="tab-pane fade" id="trusted-by" role="tabpanel" aria-labelledby="trusted-by-tab">
                    @include('admin.settings.website.heading.trustedby')
                </div>

                <div class="tab-pane fade" id="trusted-partner" role="tabpanel" aria-labelledby="trusted-partner-tab">
                    @include('admin.settings.website.heading.trustedpartner')
                </div>

                <div class="tab-pane fade" id="about-us" role="tabpanel" aria-labelledby="about-us-tab">
                    @include('admin.settings.website.heading.aboutus')
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    @include('admin.settings.website.heading.contact')
                </div>

                <div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="product-tab">
                    @include('admin.settings.website.heading.product')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    {{ mediasingle() }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/custom/media.js') }}"></script>
@endpush
