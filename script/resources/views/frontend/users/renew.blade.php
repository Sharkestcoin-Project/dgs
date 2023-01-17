@extends('layouts.frontend.app')

@section('title', $user->name)

@section('content')
    <div class="container profile-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div id="content" class="content content-full-width">
                    <!-- begin profile -->
                    <div class="profile">
                        <div class="profile-header">
                            <!-- BEGIN profile-header-cover -->
                            <div class="profile-header-cover"></div>
                            <!-- END profile-header-cover -->
                            <!-- BEGIN profile-header-content -->
                            <div class="profile-header-content">
                                <!-- BEGIN profile-header-img -->
                                <div class="profile-header-img">
                                    <img src="{{ $user->avatar ? asset($user->avatar) : get_gravatar($user->email) }}" alt="">
                                </div>
                                <!-- END profile-header-img -->
                                <!-- BEGIN profile-header-info -->
                                <div class="profile-header-info">
                                    <h4 class="m-t-10 m-b-5">{{ $user->name }}</h4>
                                    @if(Auth::check() && Auth::id() == $user->id)
                                        <a href="#" class="btn btn-sm btn-info mb-2">{{ __('Edit Profile') }}</a>
                                    @endif
                                </div>
                                <!-- END profile-header-info -->
                            </div>
                            <!-- END profile-header-content -->
                            <!-- BEGIN profile-header-tab -->
                            <ul class="profile-header-tab nav nav-tabs">
                                <li @class(['nav-item', 'active' => Route::is('users.show')])>
                                    <a href="{{ route('users.show', $user->username) }}" class="nav-link_">
                                        {{ __('Products') }} ({{ $user->products_count }})
                                    </a>
                                </li>
                                @if($user->plans_count > 0)
                                <li @class(['nav-item', 'active' => Route::is('users.show.subscriptions')])>
                                    <a href="{{ route('users.show.subscriptions', $user->username) }}" class="nav-link_">
                                        {{ __('Subscriptions') }} ({{ $user->plans_count }})
                                    </a>
                                </li>
                                @endif
                            </ul>
                            <!-- END profile-header-tab -->
                        </div>
                    </div>
                    <!-- end profile -->
                    <!-- begin profile-content -->
                    <div class="profile-content">
                        <!-- All Product Area -->
                        <div class="all-product-area">
                            <div class="container">
                                <form action="{{ route('subscriptions.payment', [$user->username, $order->plan->id]) }}" method="post" class="ajaxform">
                                    @csrf
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-6 col-lg-4">
                                            <div class="single-product-area mb-50">
                                                <div class="product-img">
                                                    <img src="{{ asset($order->plan->cover) }}" alt="">
                                                    <div class="price-tag">
                                                        <h5>{{ currency_format($order->plan->price, 'icon', $order->plan->currency->symbol) }}</h5>
                                                        <span class="video-sonar"></span>
                                                    </div>
                                                </div>
                                                <div class="product-details-area">
                                                    <a href="{{ route('products.show', $order->plan->id) }}">
                                                        <h5>{{ $order->plan->name }}</h5>
                                                    </a>
                                                    <div class="modal-body-header d-flex align-items-center">
                                                        <div class="modal-logo">
                                                            <img src="{{ $order->plan->user->avatar ?? get_gravatar($order->plan->user->email) }}" alt="">
                                                        </div>
                                                        <span>{{ $order->plan->user->name }}</span>
                                                    </div>
                                                    <div class="product-desc">
                                                                <span>
                                                                    @php
                                                                        $description = $order->plan->description;
                                                                            if (strlen($description) > 100) {
                                                                                 $description = substr($description , 0, 100);

                                                                                 $description = substr($description,0, strrpos($description,' '));

                                                                                 echo $description = $description." <a class='text-secondary has-read-more' href='#'>Read More...</a>";
                                                                             }else{
                                                                                echo $description;
                                                                             }
                                                                    @endphp
                                                                </span>
                                                        <span class="full-text d-none">
                                                                    {{ $order->plan->description }}
                                                                </span>
                                                    </div>


                                                    <ul class="list-group list-group-flush">
                                                        @foreach($order->plan->features ?? [] as $feature)
                                                            <li class="list-group-item bg-transparent">
                                                                <i class="fas fa-check"></i>
                                                                {{ $feature['title'] }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        {{ __('Your billing address') }}
                                                    </h5>
                                                    <div class="form__box mb-20">
                                                        <input type="text" name="name" id="name" class="form__input" value="{{ $order->subscriber->name }}" placeholder="{{ __('Name') }}" required>
                                                        <label for="name" class="form__label">{{ __('Name') }}</label>
                                                        <div class="form__shadow"></div>
                                                    </div>
                                                    <div class="form__box mb-20">
                                                        <input type="email" name="email" id="email" class="form__input" value="{{ $order->subscriber->email }}" placeholder="{{ __('Email') }}" required>
                                                        <label for="email" class="form__label">{{ __('Email') }}</label>
                                                        <div class="form__shadow"></div>
                                                    </div>
                                                    <div class="form__box mb-20">
                                                        <input type="tel" name="phone" id="phone" class="form__input" value="{{ $order->subscriber->phone }}" placeholder="{{ __('Phone') }}" required>
                                                        <label for="phone" class="form__label">{{ __('Phone') }}</label>
                                                        <div class="form__shadow"></div>
                                                    </div>

                                                    <div class="button-area text-center mt-30 mb-3">
                                                        <!-- Button -->
                                                        <button
                                                            type="submit"
                                                            class="btn hero-btn d-block w-100"
                                                        >
                                                            {{ __('Renew') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end profile-content -->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/profile.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
