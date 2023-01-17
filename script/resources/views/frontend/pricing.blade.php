@extends('layouts.frontend.app')

@section('title', __('Our Price'))

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.pricing')])

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
                    <div class="row justify-content-center">
                        @foreach($data['plans'] ?? [] as $item)
                            @if(Auth::check() && $item->price < 1)
                                @continue
                            @endif
                            <!-- Single Price Table -->
                            <div class="col-md-6 col-lg-4">
                                <div class="single-price-table mb-50">
                                    <!-- Pricing Header -->
                                    <div class="pricing-header">
                                        <h6>{{ $item->name }}</h6>
                                        <h2>{{ $item['price'] < 0 ? currency_format(0) : currency_format($item['price']) }}
                                            <span>/ @if($item['duration'] < 0)
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
                                                @endif
                                            </span>
                                        </h2>
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
                                            @if(Auth::check() && Auth::user()->plan_id == $item->id)
                                                <a class="price-btn d-block text-uppercase" disabled>
                                                    {{ __('Subscribed') }}
                                                </a>
                                            @elseif(Auth::check())
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

    <!-- Feature Area -->
    <div class="feature-area section-padding-100-50">
        <div class="container">
            @if(isset($data['headings']['heading.feature']))
                @php
                    $feature = $data['headings']['heading.feature'];
                @endphp
                <div class="row align-items-center">
                    <!-- Single Feature -->
                    <div class="col-md-6 col-lg-4">
                        <div class="single-feature-area mb-50">
                            <div class="feature-icon">
                                <i class="{{ $feature['feature_1_icon'] ?? null }}"></i>
                            </div>
                            <h4>{{ $feature['feature_1_text'] ?? null }}</h4>
                            <p>{{ $feature['feature_1_description'] ?? null }}</p>
                            <a class="feature-btn" href="{{ $feature['button_url'] ?? null }}">{{ $feature['button_text'] }} <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="single-feature-area mb-50">
                            <div class="feature-icon">
                                <i class="{{ $feature['feature_1_icon'] ?? null }}"></i>
                            </div>
                            <h4>{{ $feature['feature_1_text'] ?? null }}</h4>
                            <p>{{ $feature['feature_1_description'] ?? null }}</p>
                            <a class="feature-btn" href="{{ $feature['button_url'] ?? null }}">{{ $feature['button_text'] }} <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>

                    <!-- Single Feature -->
                    <div class="col-md-6 col-lg-4">
                        <div class="single-feature-area mb-50">
                            <div class="feature-icon">
                                <i class="{{ $feature['feature_1_icon'] ?? null }}"></i>
                            </div>
                            <h4>{{ $feature['feature_1_text'] ?? null }}</h4>
                            <p>{{ $feature['feature_1_description'] ?? null }}</p>
                            <a class="feature-btn" href="{{ $feature['button_url'] ?? null }}">{{ $feature['button_text'] }} <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            @else
                <x-admin-can-update
                    :text="__('Edit Pricing Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'pricing-tab'])"
                />
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
