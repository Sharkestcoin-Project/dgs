@extends('layouts.frontend.app')

@section('title', __('All Products'))

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.all_product')])

    <!-- All Product Area -->
    <div class="all-product-area section-padding-100-50">
        <div class="container">
            @if(isset($heading))
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="heading-title text-center">
                        <h3>{{ $heading['title'] ?? null }}</h3>
                        <p>{{ $heading['description'] ?? null }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                @foreach($products as $product)
                <!-- Single Product -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-product-area mb-50">
                        <div class="product-img">
                            <img src="{{ $product->cover  }}" alt="">
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
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
