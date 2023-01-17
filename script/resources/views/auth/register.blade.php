@extends('layouts.frontend.app')

@section('title', __('Register'))

@section('content')

    <!-- Login Area -->
    <div class="login-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="row align-items-center justify-content-center">
                        <!-- Login form -->
                        <div class="col-sm-10 col-md-8 col-lg-6">
                            <div class="login-content">
                                <h6>{{ __('Welcome') }}</h6>
                                <h2 class="login-title">{{ __('Sign Up To Your Account') }}
                                </h2>
                                <form action="{{ route('register') }}" method="post" class="ajaxform_with_redirect">
                                    @csrf
                                    <div class="form__box mb-20">
                                        <input type="text" name="name" id="name" class="form__input" placeholder="{{ __('Your name') }}" required>
                                        <label for="name" class="form__label">{{ __('Your Name') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <div class="form__box mb-20">
                                        <input type="email" name="email" id="email" class="form__input" placeholder="{{ __('Your email') }}" required>
                                        <label for="email" class="form__label">{{ __('Your Email') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <div class="form__box mb-20">
                                        <input type="tel" name="phone" id="phone" class="form__input" placeholder="{{ __('Your phone') }}" required>
                                        <label for="phone" class="form__label">{{ __('Your Phone') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <div class="form__box mb-20">
                                        <input type="password" name="password" id="password" class="form__input" min="8" placeholder="{{ __('Password') }}" required>
                                        <label for="password" class="form__label">{{ __('Password') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <div class="form__box mb-20">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form__input" min="8" placeholder="{{ __('Confirm Password') }}" required>
                                        <label for="password_confirmation" class="form__label">{{ __('Confirm Password') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <div class="form-group form-check">
                                        <input class="form-check-input" name="agree" type="checkbox" value="1" id="agree">
                                        <label class="form-check-label" for="agree">
                                            {{ __('You have to agree with our') }} <a href="{{ route('terms.index') }}">{{ __('Terms Of Service') }}</a>
                                        </label>
                                    </div>


                                    <div class="button-area text-center mt-30 mb-3">
                                        <!-- Button -->
                                        <button type="submit" class="btn hero-btn basicbtn">{{ __('Submit') }}</button>
                                    </div>
                                </form>

                                <!-- Other Sign Up -->
                                <div class="other-sign-up-area text-center">
                                    <span>
                                        {{ __('Already have an account?') }}
                                        <a class="forgot-btn" href="{{ route('login') }}">
                                            {{ __('Login Now') }}
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="login-img">
                                <img src="{{ asset('frontend/img/bg-img/13.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
