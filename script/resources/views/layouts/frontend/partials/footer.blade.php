@php
    $footer = get_option('footer_setting');
    $logos = get_option('logo_setting');
    $languages = get_option('languages');
    $demo = get_option('demo_product');
    if (isset($demo) && Storage::disk(config('filesystems.default'))->exists($demo['file'] ?? "blah")){
        $demoFileSize = Storage::disk(config('filesystems.default'))->size($demo['file']);
    }else{
        $demoFileSize = 0;
    }
@endphp

<!-- Call To Action Area -->
<div class="call-to-action-area">
    <div class="container">
        @php
            $callToAction = get_option('heading.call-to-action');
        @endphp
        @if(isset($callToAction))
            <div class="row">
                <div class="col-12">
                    <div class="call-to-action-card d-sm-flex align-items-center justify-content-between">
                        <div class="call-to-text">
                            <h2>{{ $callToAction['title'] ?? null }}</h2>
                            <span>{{ $callToAction['description'] ?? null }}</span>
                        </div>

                        <div class="call-to-btn">
                            <a href="{{ $callToAction['button_url'] }}">{{ $callToAction['button_text'] }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <x-admin-can-update
                :text="__('Edit Call To Action Section')"
                :url="route('admin.settings.website.heading.index', ['trigger' => 'call-to-action-tab'])"
            />
        @endif
    </div>
</div>
<!-- Call To Action Area -->

<!-- Footer Area -->
<div class="footer-contact-area bg-gray-cu section-padding-100-50">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Footer Widget -->
            <div class="col-sm-5 col-lg-4">
                <div class="footer-single-widget left mb-50">
                    <div class="footer-logo">
                        <a href="{{ url('/') }}"><img src="{{ $logos['logo'] ?? null }}" alt="{{ config('app.name') }}"></a>
                    </div>
                    <p>{{ $footer['description'] ?? null }}</p>
                    <!-- News Letter Area -->
                    <div class="newsletter-form mb-4">
                        <form action="{{ route('newsletter.subscribe') }}" class="ajaxform_with_redirect_without_validation" method="post">
                            @csrf
                            <input class="form-control" type="email" name="email" placeholder="{{ __('Enter email') }}" required>
                            <button class="btn submit-btn px-3" type="submit">{{ __('Submit') }}</button>
                        </form>
                    </div>
                    <!-- Footer Social Area -->
                    <ul class="footer-social-area">
                        @foreach($footer['social'] ?? [] as $social)
                            <li>
                                <a href="{{ $social['website_url'] }}"><i class="{{ $social['icon_class'] }}"></i></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-sm-7 col-lg-7">
                <div class="row">
                    <!-- Footer Widget -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="footer-single-widget first mb-50">
                            {{ RenderMenu('footer_left_menu', 'components.menu.footer') }}
                        </div>
                    </div>
                    <!-- Footer Widget -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="footer-single-widget first mb-50">
                            {{ RenderMenu('footer', 'components.menu.footer') }}
                        </div>
                    </div>

                    <!-- Footer Widget -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="footer-single-widget second mb-50">
                            {{ RenderMenu('footer_right_menu', 'components.menu.footer') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Copy Right Area -->
<div class="bootom-copy-right-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="copywrite-bottom-area d-lg-flex align-items-lg-center justify-content-lg-between">
                    <!-- Copywrite Text -->
                    <div class="copywrite-text text-center">
                        <p class="mb-0">@if($footer['copyright']) {{ $footer['copyright'] }} @else {{ 'Copyright © '.date('Y').'. All Rights Reserved' }} {{ __('by') }} <a href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a> @endif</p>
                    </div>
                    <!-- Dropup -->
                    <div class="language-dropdown text-center text-lg-end">
                        @foreach($languages ?? [] as $code => $language)
                         @php
                         if($code ==  current_locale()){
                            $current_locale=  $language;
                         }

                         @endphp
                         @endforeach

                        <button class="copy-btn btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          {{ $current_locale ?? __('Language') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach($languages ?? [] as $code => $language)
                                <a class="dropdown-item" href="{{ route('set-language', $code) }}">{{ $language }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bottom Copy Right Area -->

<!-- Try Demo Button trigger modal -->
@if(isset($demo))
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header try-demo">
                    <img src="{{ $demo['product_cover'] ?? null }}" alt="">
                    <div class="price-tag">
                        <h5>{{ currency_format($demo['price'] ?? 0) }}</h5>
                        <span class="video-sonar"></span>
                    </div>

                </div>
                <div class="modal-body try-demo-form">
                    <h5>{{ $demo['title'] ?? null }}</h5>
                    <div class="modal-body-header d-flex align-items-center">
                        <div class="modal-logo">
                            <img src="{{ $demo['user_avatar'] ?? null }}" alt="">
                        </div>
                        <span>{{ $demo['user_name'] ?? null }}</span>
                    </div>
                    <span class="less-text">
                    @php
                        $description = $demo['description'] ?? null;
                            if (strlen($description) > 100) {
                                 $description = substr($description , 0, 100);

                                 $description = substr($description,0, strrpos($description,' '));

                                 echo $description = $description." <a class='text-secondary has-read-more' href='#'>".__('Read More...')."</a>";
                             }
                    @endphp
                </span>
                    <span class="full-text d-none">
                    {{ $demo['description'] ?? null }} <a class='text-secondary has-read-less' href='#'>{{ __('Read Less') }}</a>
                </span>

                    <div class="product-desc">
                        <p>
                            <i class="fas fa-file-download"></i>
                            {{ __(':type File', ['type' => str($demo['file'] ?? "")->upper()->explode('.')->last()]) }} – {{ human_filesize($demoFileSize) }}
                        </p>
                    </div>

                    <div class="modal-form-area">
                        <form action="{{ route('demo.email') }}" method="post" class="ajaxform">
                            @csrf
                            <div class="form__box mb-20">
                                <input type="text" name="email" id="email" class="form__input" placeholder="{{ __('Email') }}">
                                <label for="email" class="form__label">{{ __('Email') }}</label>
                                <div class="form__shadow"></div>
                            </div>

                            <button type="submit" class="btn modal-try-btn basicbtn">{{ __('Continue') }}</button>
                        </form>
                    </div>
                </div>
                <!-- Payment Support -->
                <div class="support-area p-3 d-flex justify-content-between align-items-center">
                    <p>
                        <i class="fas fa-unlock mr-2">

                        </i> {{ __('Powered by') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>
                    </p>
                    <div class="support-img">
                        <img src="{{ asset('frontend/img/icons/2.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
