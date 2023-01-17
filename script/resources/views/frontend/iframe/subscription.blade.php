<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- Import css File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/new.css') }}">
</head>

<div class="container profile-wrapper">
    <div class="row justify-content-center">
        <!-- Single Product -->
        <div class="col-md-6 col-lg-4 mt-3">
            <div class="single-product-area mb-50">
                <div class="product-img">
                    <img src="{{ asset($plan->cover) }}" alt="">
                    <div class="price-tag">
                        <h5>{{ currency_format($plan->price, 'icon', $plan->currency->symbol) }}</h5>
                        <span class="video-sonar"></span>
                    </div>
                </div>
                <div class="product-details-area">
                    <a target="_blank" href="{{ route('users.subscriptions.show', [$plan->user->username, $plan->id]) }}">
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
                                    $description = substr($description, 0, 100);

                                    $description = substr($description, 0, strrpos($description, ' '));

                                    echo $description = $description . " <a class='text-secondary has-read-more' href='#'>Read More...</a>";
                                } else {
                                    echo $description;
                                }
                            @endphp
                        </span>
                        <span class="full-text d-none">
                            {{ $plan->description }}
                        </span>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach ($plan->features ?? [] as $feature)
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-check"></i>
                                {{ $feature['title'] }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="button-area text-center mt-30 mb-3">
                        <a target="_blank" class="btn hero-btn d-block w-100" href="{{ route('users.subscriptions.show', [$plan->user->username, $plan->id]) }}">{{ __('GO') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
