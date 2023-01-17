@extends('layouts.frontend.app')

@section('title', __('Forgot Password'))

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
                                <h2 class="login-title">{{ __('Reset Your Password') }}
                                </h2>
                                <form action="{{ route('password.email') }}" method="post" class="ajaxform">
                                    @csrf
                                    <div class="form__box mb-20">
                                        <input type="text" name="email" id="email" class="form__input" placeholder="{{ __('Email') }}" required>
                                        <label for="email" class="form__label">{{ __('Email') }}</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <div class="button-area text-center mt-30 mb-3">
                                        <!-- Button -->
                                        <button type="submit" class="btn hero-btn">{{ __('Send Password Reset Link') }}</button>
                                    </div>
                                </form>
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

