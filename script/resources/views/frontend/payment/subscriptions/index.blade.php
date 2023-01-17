<div class="single-product-page-area">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-md-6 col-lg-6 gateways">
                @include('frontend.payment.subscriptions.getGateways')
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="single-product-area">
                    <div class="product-img">
                        <img src="{{ asset($plan->cover) }}" alt="">
                        <div class="price-tag">
                            <h5>{{ currency_format($plan->price, 'icon', $plan->currency->symbol) }}</h5>
                            <span class="video-sonar"></span>
                        </div>
                    </div>
                    <div class="product-details-area">
                        <h5>{{ $plan->name }}</h5>
                        <div class="modal-body-header d-flex align-items-center">
                            <div class="modal-logo">
                                <img src="{{ $plan->user->avatar ? asset($plan->user->avatar) : get_gravatar($plan->user->email) }}" alt="">
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
                                         }
                                        else{
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
