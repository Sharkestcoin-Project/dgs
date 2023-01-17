@extends('layouts.frontend.app')

@section('content')
    <!-- Welcome Area Start -->
    <section class="welcome-area bg-img">
        <div class="effect-bg">
            <div class="radius-1"></div>
            <div class="radius-2"></div>
            <div class="radius-3"></div>
            <div class="radius-4"></div>
            <div class="radius-x"></div>
        </div>

        <div class="bg-shpae">
            <img src="{{ asset('frontend/img/bg-img/bg-img.png') }}" alt="">
        </div>
        <div class="container h-100">
            <div class="row align-items-center justify-content-center">
                @if(isset($data['headings']['heading.welcome']))
                    @php
                        $welcome = $data['headings']['heading.welcome'];
                    @endphp
                    <!-- Welcome Text -->
                    <div class="col-lg-8 col-xl-7">
                        <div class="welcome-text text-center">
                            <h2>{{ $welcome['title'] ?? null }}</h2>
                            <p>{{ $welcome['description'] ?? null }}
                            </p>
                            <div class="button-area">
                                @isset($welcome['button1_text'])
                                    <a class="hero-btn first mr-15-cu mb-2" href="{{ $welcome['button1_url'] ?? null }}">{{ $welcome['button1_text'] ?? null }}</a>
                                @endisset
                                @isset($welcome['button2_text'])
                                    <button type="button" class="btn hero-btn-2 mb-2" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                        {{ $welcome['button2_text'] ?? null }}
                                    </button>
                                @endisset
                            </div>
                        </div>
                    </div>

                    @isset($welcome['image'])
                        <!-- Welcome Thumb -->
                        <div class="col-12 col-lg-8">
                            <div class="welcome-thumb-area text-center">
                                <img src="{{ $welcome['image'] ?? null }}" alt="">
                            </div>
                        </div>
                    @endisset
                @else
                    <x-admin-can-update
                        :text="__('Edit Welcome Section')"
                        :url="route('admin.settings.website.heading.index', ['trigger' => 'welcome-tab'])"
                    />
                @endif

            </div>
        </div>
    </section>
    <!-- Welcome Area End -->

    <!-- Feature Area -->
    <div class="feature-area section-padding-100-50 bg-gray-cu">
        <div class="container">
            @if(isset($data['headings']['heading.feature']))
                @php
                    $feature = $data['headings']['heading.feature'];
                @endphp
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="feature-text-content mb-50">
                            <h2>{{ $feature['title'] ?? null }}</h2>
                            <p>{{ $feature['description'] ?? null }}</p>
                            <div class="button-area mt-5">
                                <a class="hero-btn first" href="{{ $feature['button_url'] }}">{{ $feature['button_text'] }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row align-items-center">
                            <!-- Single Feature -->
                            <div class="col-md-6">
                                @isset($feature['feature_1_text'])
                                <div class="single-feature-area mb-50">
                                    <div class="feature-icon">
                                        <i class="{{ $feature['feature_1_icon'] }}"></i>
                                    </div>
                                    <h4>{{ $feature['feature_1_text'] }}</h4>
                                    <p>{{ $feature['feature_1_description'] }}</p>
                                    <a class="feature-btn" href="{{ $feature['button_url'] }}">{{ $feature['button_text'] }} <i class="fas fa-chevron-right"></i></a>
                                </div>
                                @endisset

                                @isset($feature['feature_2_text'])
                                    <div class="single-feature-area mb-50">
                                        <div class="feature-icon">
                                            <i class="{{ $feature['feature_2_icon'] }}"></i>
                                        </div>
                                        <h4>{{ $feature['feature_2_text'] }}</h4>
                                        <p>{{ $feature['feature_2_description'] }}</p>
                                        <a class="feature-btn" href="{{ $feature['button_url'] }}">{{ $feature['button_text'] }} <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                @endisset

                            </div>

                            <!-- Single Feature -->
                            <div class="col-md-6">
                                @isset($feature['feature_3_text'])
                                    <div class="single-feature-area mb-50">
                                        <div class="feature-icon">
                                            <i class="{{ $feature['feature_3_icon'] }}"></i>
                                        </div>
                                        <h4>{{ $feature['feature_3_text'] }}</h4>
                                        <p>{{ $feature['feature_3_description'] }}</p>
                                        <a class="feature-btn" href="{{ $feature['button_url'] }}">{{ $feature['button_text'] }} <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <x-admin-can-update
                    :text="__('Edit Feature Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'feature-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- Feature Area -->

    <!-- About Us Area -->
    <div class="about-us-area section-padding-100-50">
        <div class="container">
            @if(isset($data['headings']['heading.about']))
                @php
                    $about = $data['headings']['heading.about'];
                @endphp
                <div class="row align-items-center">
                    <!-- About Image -->
                    <div class="col-lg-5 col-xl-6">
                        <div class="about-image mb-50">
                            <img src="{{ $about['image'] ?? null }}" alt="">
                        </div>
                    </div>

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

    <!-- Our service Area -->
    <div class="our-service-area section-padding-0-50">
        <div class="effect-bg">
            <div class="radius-1"></div>
            <div class="radius-2"></div>
            <div class="radius-3"></div>
            <div class="radius-4"></div>
            <div class="radius-x"></div>
        </div>
        <div class="container">
            @if(isset($data['headings']['heading.our-service']))
                @php
                    $ourService = $data['headings']['heading.our-service'];
                @endphp
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="heading-title text-center">
                            <h3>{{ $ourService['title'] ?? null }}</h3>
                            <p>{{ $ourService['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>

                @if(isset($data['our_services']) && count($data['our_services']) > 0)
                    <div class="row">
                        @foreach($data['our_services'] ?? [] as $item)
                            <!-- Single Service -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="single-service-area mb-50">
                                    <div class="service-icon">
                                        <i class="{{ $item->icon }}"></i>
                                    </div>
                                    <div class="service-text">
                                        <h4>
                                            <a href="#">{{ $item->title }}</a>
                                        </h4>
                                        <p>{{ $item->description }}</p>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-admin-can-update
                        :text="__('Create Service Section')"
                        :url="route('admin.settings.website.our-services.create')"
                    />
                @endif
            @else
                <x-admin-can-update
                    :text="__('Edit Our Service Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'our-service-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- Our service Area -->

    <!-- Price Plan Area -->
    <div class="price-plan-area bg-gray-cu section-padding-100-50">
        <div class="container">
            @if(isset($data['headings']['heading.pricing']))
                @php
                    $pricing = $data['headings']['heading.pricing'];
                @endphp
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="heading-title text-center">
                            <h3>{{ $pricing['title'] ?? null }}</h3>
                            <p>{{ $pricing['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>

                @if(isset($data['plans']) && count($data['plans']) > 0)
                    <div class="row">
                        @foreach($data['plans'] ?? [] as $item)
                            <!-- Single Price Table -->
                            <div class="col-md-6 col-lg-4">
                                <div class="single-price-table mb-50">
                                    <!-- Pricing Header -->
                                    <div class="pricing-header">
                                        <h6>{{ $item->name }}</h6>
                                        <h2>{{ $item['price'] < 0 ? currency_format(0) : currency_format($item['price']) }} <span>/ @if($item['duration'] < 0)
                                                    {{ __('Lifetime') }}
                                                @else
                                                    @if(in_array($item['duration'], [30, 31]))
                                                        {{ __('Monthly') }}
                                                    @elseif(in_array($item['duration'], [360, 365]))
                                                        {{ __('Yearly') }}
                                                    @elseif($item['duration'] < 0)
                                                        {{ __('Unlimited') }}
                                                    @else
                                                        {{$item['duration']}}
                                                        {{ __('Days') }}
                                                    @endif
                                                @endif</span></h2>
                                        <p>{{ __('+:number% / sale', ['number' => $item->commission]) }}</p>
                                    </div>

                                    <!-- Pricing Body -->
                                    <div class="pricing-body">
                                        <ul>
                                            @foreach($item->meta as $key => $value)
                                                @continue($key == 'commission')
                                                <li>
                                                    @if($value == 0)
                                                        <i class="fas fa-times"></i>
                                                    @else
                                                        <i class="fas fa-check"></i>
                                                    @endif

                                                    @if($key == "max_file_size")
                                                        {{ human_filesize($value * 1048576) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif

                                                    {{ str($key)->explode('_')->map(fn($word) => str($word)->ucfirst())->implode(' ') }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="button-area text-center mt-5">
                                            @if(Auth::user())
                                                <a class="price-btn confirm-action d-block text-uppercase" href="javascript:void(0)" data-action="{{ route('user.settings.subscriptions.store', ['plan' => $item->id]) }}">
                                                    {{ __('Select') }}
                                                </a>
                                            @else
                                                <a class="price-btn d-block text-uppercase" href="{{ route('register') }}">
                                                    {{ __('Sign Up') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-admin-can-update
                        :text="__('Create Plan')"
                        :url="route('admin.plans.create')"
                    />
                @endif
            @else
                <x-admin-can-update
                    :text="__('Edit Pricing Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'pricing-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- Price Plan Area -->

    <!-- Client Area Css -->
    <div class="client-area section-padding-100">
        <div class="container">
            @if(isset($data['headings']['heading.review']))
                @php
                    $review = $data['headings']['heading.review'];
                @endphp
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="heading-title text-center">
                            <h3 class="text-white">{{ $review['title'] ?? null }}</h3>
                            <p class="text-white">{{ $review['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>

                @if(isset($data['reviews']) && count($data['reviews']) > 0)
                    <div class="row">
                        <div class="client-slider owl-carousel">
                            <!-- Single Client Slider -->
                            @foreach($data['reviews'] ?? [] as $item)
                                <div class="single-clinet-slider">
                                    <div class="client-text">
                                        <div class="client-rating">
                                            {!! star_rating($item->rating) !!}
                                        </div>
                                        <p>{{ $item->comment }}</p>

                                        <!-- Client Bottom -->
                                        <div class="client-bottom-area d-flex align-content-center">
                                            <div class="client-img">
                                                <img src="{{ $item->image }}" alt="">
                                            </div>

                                            <div class="client-info">
                                                <h6>{{ $item->name }}</h6>
                                                <span>{{ $item->position }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <x-admin-can-update
                        :text="__('Create Review')"
                        :url="route('admin.reviews.create')"
                        class="btn btn-outline-light"
                    />
                @endif
            @else
                <x-admin-can-update
                    :text="__('Edit Review Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'review-tab'])"
                    class="btn btn-outline-light"
                />
            @endif
        </div>
    </div>
    <!-- Client Area Css -->

    <div class="faq-area section-padding-100-50">
        <div class="container">
            @if(isset($data['headings']['heading.faq']))
                @php
                    $faq = $data['headings']['heading.faq'];
                @endphp
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="heading-title text-center">
                            <h3>{{ $faq['title'] ?? null }}</h3>
                            <p>{{ $faq['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>

                @if(isset($data['faqs']) && count($data['faqs']) > 0)
                    <div class="row align-items-center">
                        <div class="col-12 col-md-7 col-lg-6">
                            <div class="faq-content mb-50">
                                <h2 class="mb-5">{{ $faq['title'] ?? null }}</h2>
                                <div class="accordion faq-accordian " id="faqaccordian">
                                    <!-- Single FAQ -->
                                    @foreach($data['faqs'] ?? [] as $item)
                                    <div class="card border-0">
                                        <div class="card-header" id="heading{{ $loop->index }}">
                                            <button @class(['btn', 'collapsed' => !$loop->last]) type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $loop->last ? 'true' : 'false' }}"
                                                    aria-controls="collapse{{ $loop->index }}">{{ $item->question }}</button>
                                        </div>
                                        <div @class(['collapse', 'show' => $loop->last]) id="collapse{{ $loop->index }}" aria-labelledby="heading{{ $loop->index }}"
                                             data-bs-parent="#faqaccordian">
                                            <div class="card-body">
                                                <p>{{ $item->answer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Faq Image -->
                        <div class="col-12 col-md-5 col-lg-6 mb-50 text-center">
                            <div class="faq-image">
                                <img src="{{ $faq['image'] ?? null }}" alt="">
                            </div>
                        </div>
                    </div>
                @else
                    <x-admin-can-update
                        :text="__('Edit Faq Section')"
                        :url="route('admin.settings.website.heading.index', ['trigger' => 'faq-tab'])"
                    />
                @endif
            @else
                <x-admin-can-update
                    :text="__('Edit Faq Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'faq-tab'])"
                />
            @endif
        </div>
    </div>

    <!-- Blog Area -->
    <div class="blog-area section-padding-0-50">
        <div class="container">
            @if(isset($data['headings']['heading.latest-news']))
                @php
                    $latestNews = $data['headings']['heading.latest-news'];
                @endphp
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="heading-title text-center">
                            <h3>{{ $latestNews['title'] ?? null }}</h3>
                            <p>{{ $latestNews['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>

                @if(isset($data['blog']) && count($data['blog']) > 0)
                    <div class="row">
                        <!-- Single Blog -->
                        @foreach($data['blog'] ?? [] as $post)
                        <div class="col-md-6 col-lg-4">
                            <div class="single-blog-area mb-50">
                                <div class="blog-image">
                                    <img src="{{ $post->preview->value ?? null }}" alt="">
                                </div>
                                <span class="blog-badge">{{ __('Update2') }}</span>
                                <h4>{{ $post->title ?? null }}</h4>
                                <p>{{ $post->excerpt->value ?? null }}</p>
                                <div class="blog-btn">
                                    <a href="{{ route('blog.post', $post->slug) }}">{{ __('Read more') }} <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <x-admin-can-update
                        :text="__('Create a blog post')"
                        :url="route('admin.blog.create')"
                    />
                @endif
            @else
                <x-admin-can-update
                    :text="__('Edit Latest News Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'latest-news-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- Blog Area -->
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
