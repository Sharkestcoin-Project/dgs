@extends('layouts.frontend.product')

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
                                <h6>{{ __('Verify Your Email Address') }}</h6>
                                <p>
                                    {{ __('Before proceeding, please check your email for a verification link.') }}
                                    {{ __('If you did not receive the email') }},
                                </p>
                                <form action="{{ route('verification.resend') }}" method="post" class="ajaxform">
                                    @csrf

                                    <div class="button-area text-center mt-30 mb-3">
                                        <!-- Button -->
                                        <button type="submit" class="btn hero-btn basicbtn">
                                            {{ __('Click here to request another') }}
                                        </button>
                                    </div>
                                </form>

                                <!-- Other Sign Up -->
                                <div class="other-sign-up-area text-center">
                                    <span>
                                        <a class="forgot-btn" href="javascript:void(0)" onclick="$('#logout').trigger('submit')">
                                                {{ __('Logout') }}
                                            </a>
                                        <form action="{{ route('logout') }}" method="post" id="logout">
                                            @csrf
                                        </form>
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
