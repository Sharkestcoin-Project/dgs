@extends('layouts.frontend.app')

@section('title', __('Contact US'))

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.contact')])

    <!-- Contact Area  -->
    <div class="contact-area section-padding-100-50">
        <div class="container">
            @if(isset($heading))
                <div class="row align-items-center">

                    <div class="col-lg-4">
                        <div class="contact-meta-info-area  mb-50">

                            <!-- Contact Info -->
                            <div class="contact-meta-info text-center">
                                <!-- Icon -->
                                <div class="c-meta-icon">
                                    <i class="fas fa-headphones-alt"></i>
                                </div>
                                <h4>{{ __('Phone number') }}</h4>
                                <span>{{ $heading['phone'] ?? null }}</span>
                            </div>

                            <!-- Contact Info -->
                            <div class="contact-meta-info text-center">
                                <!-- Icon -->
                                <div class="c-meta-icon">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <h4>{{ __('Email') }}</h4>
                                <span>{{ $heading['email'] ?? null }}</span>
                            </div>

                            <!-- Contact Info -->
                            <div class="contact-meta-info text-center">
                                <!-- Icon -->
                                <div class="c-meta-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <h4>{{ __('Our Location') }}</h4>
                                <span>{{ $heading['location'] ?? null }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Area -->
                    <div class="col-lg-8">
                        <div class="contact-area-card mb-50">
                            <h4>{{ $heading['title'] ?? null }}</h4>
                            <form class="nft-contact-from ajaxform_with_reset" action="{{ route('contact.send') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form__box mb-20">
                                            <input type="text" name="first_name" class="form__input" placeholder="{{ __('Enter First Name') }}">
                                            <label for="" class="form__label">{{ __('First Name') }}</label>
                                            <div class="form__shadow"></div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="form__box mb-20">
                                            <input type="text" name="last_name" class="form__input" placeholder="Enter Name">
                                            <label for="" class="form__label">{{ __('Last Name') }}</label>
                                            <div class="form__shadow"></div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="form__box mb-20">
                                            <input type="email" name="email" class="form__input" placeholder="Enter Email">
                                            <label for="" class="form__label">{{ __('Enter Email') }}</label>
                                            <div class="form__shadow"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form__box mb-20">
                                            <input type="number" name="phone" class="form__input" placeholder="Enter Number">
                                            <label for="" class="form__label">{{ __('Enter Number') }}</label>
                                            <div class="form__shadow"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                  placeholder="{{ __('Enter Details') }}"></textarea>
                                    </div>

                                    <div class="col-12 mt-3">
                                        {!! NoCaptcha::display() !!}
                                    </div>

                                    <div class="col-12 text-center mt-30">
                                        <button class="btn hero-btn" type="submit">{{ __('Send Now') }}</button>
                                    </div>
                                </div>
                            </form>
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
    <!-- Contact Area  -->

    @if(isset($heading))
    <div class="map-area">
        <iframe width="100%" height="500" id="gmap_canvas" src="{{ $heading['map_url'] ?? null }}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    </div>
    @endif

@endsection

@push('script')
    <script src="{{ asset('admin/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
    {!! NoCaptcha::renderJs() !!}
    <script>$('.ajaxform_with_reset').on('reset', () => {grecaptcha.reset()})</script>
@endpush
