@extends('layouts.frontend.app')

@section('title', __('Users'))

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.users')])

    <!-- All Product Area -->
    <div class="all-product-area section-padding-100-50">
        <div class="container">
            <div class="row justify-content-center">
                @foreach($users as $user)
                    <!-- Single Product -->
                    <div class="col-md-6 col-lg-4">
                        <div class="single-product-area mb-50">
                            <div class="product-img">
                                <img src="{{ $user->avatar ? asset($user->avatar) : get_gravatar($user->email)  }}" alt="">
                            </div>
                            <div class="product-details-area">
                                <a href="{{ route('products.show', $user->id) }}">
                                    <h5>{{ $user->name }}</h5>
                                </a>

                                <a href="{{ route('users.show', $user->username) }}" class="btn hero-btn d-block w-100">
                                    {{ __('View Profile') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $users->links('vendor/pagination/bootstrap-5') }}
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
