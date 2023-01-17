@extends('layouts.frontend.product')

@section('title', __('Product'))

@section('content')
    <!-- Single Product Page Area -->
    <div class="single-product-page-area try-demo">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-md-8 col-lg-4">
                    <div class="single-modal-content">
                        <div class="modal-header try-demo">
                            <img src="{{ asset('frontend/img/bg-img/modal.png') }}" alt="">
                            <div class="price-tag">
                                <h5>$20</h5>
                                <span class="video-sonar"></span>
                            </div>

                        </div>
                        <div class="modal-body try-demo-form">
                            <h5>Lo-fi Beats</h5>
                            <div class="modal-body-header d-flex align-items-center">
                                <div class="modal-logo">
                                    <img src="{{ asset('frontend/img/bg-img/u-3.jpg') }}" alt="">
                                </div>
                                <span>The Sell</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus, impedit libero provident
                                veritatis a optio.</p>
                            <a class="modal-btn" href="#">Read more <i class="fas fa-chevron-right"></i></a>

                            <div class="product-desc">
                                <p><i class="fas fa-file-download"></i> JPG File – 5.19 KB
                                </p>
                            </div>

                            <div class="modal-form-area">
                                <form>
                                    <div class="form__box mb-20">
                                        <input type="text" class="form__input" placeholder="Email">
                                        <label for="" class="form__label">Email</label>
                                        <div class="form__shadow"></div>
                                    </div>

                                    <button type="submit" class="btn modal-try-btn">Continue</button>
                                </form>
                            </div>
                        </div>
                        <!-- Payment Support -->
                        <div class="support-area p-3 d-flex justify-content-between align-items-center">
                            <p><i class="fas fa-unlock mr-2"></i> Powered by <a href="#">The Sell</a></p>
                            <div class="support-img">
                                <img src="{{ asset('frontend/img/icons/2.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product Page Area -->
@endsection
