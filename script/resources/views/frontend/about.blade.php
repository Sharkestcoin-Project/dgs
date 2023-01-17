@extends('layouts.frontend.app')

@section('title', __('About'))

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.about')])

    <!-- About Us Area -->
    <div class="about-us-area section-padding-100-50">
        <div class="container">
            @if(isset($data['headings']['heading.about-us']))
                @php
                    $aboutUs = $data['headings']['heading.about-us'];
                @endphp
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="about-us-text-2 mb-50">
                            <h6>{{ $aboutUs['heading'] ?? null }}</h6>
                            <h3>{{ $aboutUs['title'] ?? null }}</h3>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="about-us-desc-2 mb-50">
                            <p>{{ $aboutUs['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>
            @else
                <x-admin-can-update
                    :text="__('Edit About Us Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'about-us-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- About Us Area -->

    <!-- About Us Area -->
    <div class="about-us-area section-padding-100-50">
        <div class="container">
            @if(isset($data['headings']['heading.about']))
                @php
                    $about = $data['headings']['heading.about'];
                @endphp
                <div class="row align-items-center">
                    <!-- About Text -->
                    <div class="col-lg-7 col-xl-6">
                        <div class="about-us-text mb-30">
                            <h6>{{ $about['heading'] ?? null }}</h6>
                            <h2>{{ $about['title'] ?? null }}</h2>
                            <p>{{ $about['description'] ?? null }}</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single-about-card">
                                        <p>
                                            <i class="fas fa-check"></i>
                                            <span>{{ $about['option_1'] ?? null }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-about-card">
                                        <p>
                                            <i class="fas fa-check"></i>
                                            <span>{{ $about['option_2'] ?? null }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-about-card">
                                        <p>
                                            <i class="fas fa-check"></i>
                                            <span>{{ $about['option_3'] ?? null }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-about-card">
                                        <p>
                                            <i class="fas fa-check"></i>
                                            <span>{{ $about['option_4'] ?? null }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- About Image -->
                    <div class="col-lg-5 col-xl-6">
                        <div class="about-image mb-50">
                            <img src="{{ $about['image'] ?? null }}" alt="">
                        </div>
                    </div>
                </div>
            @else
                <x-admin-can-update
                    :text="__('Edit About Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'about-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- About Us Area -->

    <!-- Counter Up Area -->
    <div class="counter-up-area section-padding-100-50">
        <div class="container">
            @if(isset($data['headings']['heading.trusted-by']))
                @php
                    $trustedBy = $data['headings']['heading.trusted-by'];
                @endphp
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="counter-text mb-50">
                            <h2>{{ $trustedBy['title'] ?? null}}</h2>
                            <p>{{ $trustedBy['description'] ?? null }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <!-- Single Counter -->
                            <div class="col-md-6">
                                <div class="single-counter-card mb-50">
                                    <h2>{{ $trustedBy['widget_1_title'] ?? null }}</h2>
                                    <p>{{ $trustedBy['widget_1_description'] ?? null }}</p>
                                </div>
                            </div>

                            <!-- Single Counter -->
                            <div class="col-md-6">
                                <div class="single-counter-card mb-50">
                                    <h2>{{ $trustedBy['widget_2_rating'] ?? null }}</h2>
                                    <div class="client-rating about text-warning">
                                        {!! star_rating($trustedBy['widget_2_rating'] ?? 0) !!}
                                    </div>
                                    <p>{{ $trustedBy['widget_2_rating_count'] ?? null }} {{ __('Rating') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <x-admin-can-update
                    :text="__('Edit Trusted By Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'trusted-by-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- Counter Up Area -->

    <!-- Partner Area -->
    <div class="partner-area section-padding-0-100">
        <div class="container">
            @if(isset($data['headings']['heading.trusted-partner']))
                @php
                    $trustedPartner = $data['headings']['heading.trusted-partner'];
                @endphp
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="heading-title text-center">
                            <h3>{{ $trustedPartner['title'] ?? null }}</h3>
                            <p>{{ $trustedPartner['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>

                @if(isset($data['trustedPartners']) && count($data['trustedPartners']) > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="parnet-slider owl-carousel">
                                @foreach($data['trustedPartners'] ?? [] as $item)
                                    <!-- Single Slider -->
                                    <div class="single-partner-slider">
                                        <a href="{{ $item['website_link'] ?? null }}"> <img src="{{ $item['image'] ?? null }}" alt="{{ $item['title'] ?? null }}"></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <x-admin-can-update
                        :text="__('Create Trusted Partner')"
                        :url="route('admin.settings.website.trusted-partner.create')"
                    />
                @endif
            @else
                <x-admin-can-update
                    :text="__('Edit Trusted Partner Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'trusted-partner-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- Partner Area -->

@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
