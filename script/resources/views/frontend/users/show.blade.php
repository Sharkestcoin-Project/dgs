@extends('layouts.frontend.app')

@section('title', $user->name)

@section('content')
<!-- begin profile -->
<div class="profile">
    <div class="profile-header">
        <!-- BEGIN profile-header-cover -->
        @if ($user->meta['cover_img'] ?? false)
        <div class="profile-header-cover" style="background-image: url({{ asset($user->meta['cover_img']) }})"></div>
        @else
        <div class="profile-header-cover" style="background-image: url(https://bootdey.com/img/Content/bg1.jpg)"></div>
        @endif
        <!-- END profile-header-cover -->

        <!-- END profile-header-content -->

    </div>
    <!-- BEGIN profile-header-content -->
    <div class="profile-header-content text-center">
        <!-- BEGIN profile-header-img -->
        <div class="profile-header-img">
            <img src="{{ $user->avatar ? asset($user->avatar) : get_gravatar($user->email) }}" alt="">
        </div>
        <!-- END profile-header-img -->
        <!-- BEGIN profile-header-info -->
        <div class="profile-header-info">
            <h4 class="m-t-10 m-b-5">{{ $user->name }}</h4>
            @if(Auth::check() && Auth::id() == $user->id)
                <a href="{{ route('user.profile.edit') }}" class="btn btn-sm btn-primary text-uppercase mb-2">{{ __('Edit Profile') }}</a>
            @endif
        </div>
        <!-- END profile-header-info -->
    </div>
    <!-- BEGIN profile-header-tab -->
    <ul class="profile-header-tab text-center">
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
<!-- end profile -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="content" class="content content-full-width">
                    <!-- begin profile-content -->
                    <div class="profile-content">
                        <!-- All Product Area -->
                        <div class="all-product-area">
                            <div class="container">
                                <div class="row justify-content-center">
                                    @if(isset($products))
                                        @foreach($products as $product)
                                            <!-- Single Product -->
                                            <div class="col-md-6 col-lg-4">
                                                <div class="single-product-area mb-50">
                                                    <div class="product-img">
                                                        <img src="{{ asset($product->cover) }}" alt="">
                                                        <div class="price-tag">
                                                            <h5>{{ currency_format($product->price, 'icon', $product->currency->symbol) }}</h5>
                                                            <span class="video-sonar"></span>
                                                        </div>
                                                    </div>
                                                    <div class="product-details-area">
                                                        <a href="{{ route('products.show', $product->id) }}">
                                                            <h5>{{ $product->name }}</h5>
                                                        </a>
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
                                                                {{ __(':type File', ['type' => $product->mimeType]) }} –
                                                                @if ($product->meta['direct_url'] ?? false)
                                                                    {{ __('LINK') }}
                                                                @else
                                                                    {{ human_filesize($product->size) }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <form action="{{ route('order.index', $product->id) }}" method="POST">
                                                            @csrf

                                                            <div class="form__box mb-20">
                                                                <input type="text" name="name" id="name-{{ $loop->index }}" class="form__input" placeholder="{{ __('Your Name') }}" min="5" required>
                                                                <label for="name-{{ $loop->index }}" class="form__label">{{ __('Your Name') }}</label>
                                                                <div class="form__shadow"></div>
                                                            </div>

                                                            <div class="form__box mb-20">
                                                                <input type="email" name="email" id="email-{{ $loop->index }}" class="form__input" placeholder="{{ __('Your Email') }}" required>
                                                                <label for="email-{{ $loop->index }}" class="form__label">{{ __('Your Email') }}</label>
                                                                <div class="form__shadow"></div>
                                                            </div>

                                                            <div class="button-area text-center mt-30 mb-3">
                                                                <!-- Button -->
                                                                <button type="submit" class="btn hero-btn d-block w-100">{{ __('Pay') }}</button>
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
                                        @endforeach
                                    @elseif(isset($plans))
                                        @forelse($plans as $plan)
                                            <!-- Single Product -->
                                            <div class="col-md-6 col-lg-4">
                                                <div class="single-product-area mb-50">
                                                    <div class="product-img">
                                                        <img src="{{ asset($plan->cover) }}" alt="">
                                                        <div class="price-tag">
                                                            <h5>{{ currency_format($plan->price, 'icon', $plan->currency->symbol) }}</h5>
                                                            <span class="video-sonar"></span>
                                                        </div>
                                                    </div>
                                                    <div class="product-details-area">
                                                        <a href="{{ route('users.subscriptions.show', [$plan->user->username, $plan->id]) }}">
                                                            <h5>{{ $plan->name }}</h5>
                                                        </a>
                                                        <div class="modal-body-header d-flex align-items-center">
                                                            <div class="modal-logo">
                                                                <img src="{{ $plan->user->avatar ?? get_gravatar($plan->user->email) }}" alt="">
                                                            </div>
                                                            <span>{{ $plan->user->name }}</span>
                                                        </div>
                                                        <div class="product-desc">
                                                            <span>
                                                                @php
                                                                    $description = $plan->description;
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
                                                                {{ $plan->description }}
                                                            </span>
                                                        </div>


                                                        <ul class="list-group list-group-flush">
                                                            @foreach($plan->features ?? [] as $feature)
                                                                <li class="list-group-item bg-transparent">
                                                                    <i class="fas fa-check"></i>
                                                                    {{ $feature['title'] }}
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                        <div class="button-area text-center mt-30 mb-3">
                                                            <!-- Button -->
                                                            <button
                                                                type="button"
                                                                class="btn hero-btn d-block w-100 subscription-select"
                                                                data-plan="{{ $plan->id }}"
                                                                data-url="{{ route('user.get-plan', [$user->username, $plan->id]) }}"
                                                            >
                                                                {{ __('Select') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            No Subscriptions Found
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end profile-content -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="subscription-modal-body">

            </div>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/profile.css') }}">
@endpush

@push('script')
    <script src="{{ asset('frontend/js/subscription.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
