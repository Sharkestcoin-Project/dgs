@extends('layouts.frontend.app')

@section('title', __('Login'))

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
                                <h2 class="login-title">{{ __('Log In To Your Account') }}
                                </h2>
                                <form action="{{ route('login') }}" method="post" class="ajaxform_with_redirect">
                                    @csrf
                                    <div class="form__box mb-20">
                                        <input type="text" name="email" id="email" class="form__input" placeholder="{{ __('Email') }}" required>
                                        <label for="email" class="form__label">{{ __('Email') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <div class="form__box mb-20">
                                        <input type="password" name="password" id="password" class="form__input" placeholder="{{ __('Password') }}" required>
                                        <label for="password" class="form__label">{{ __('Password') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <a class="forgot-btn" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>

                                    <div class="button-area text-center mt-30 mb-3">
                                        <!-- Button -->
                                        <button type="submit" class="btn hero-btn basicbtn">{{ __('Login') }}</button>
                                    </div>
                                </form>

                                <!-- Other Sign Up -->
                                <div class="other-sign-up-area text-center">
                                    <p>{{ __('Or Sign Up Using') }}</p>
                                    <span>
                                        {{ __('Don\'t have an account?') }}
                                        <a class="forgot-btn" href="{{ route('register') }}">
                                            {{ __('Create free account') }}
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
