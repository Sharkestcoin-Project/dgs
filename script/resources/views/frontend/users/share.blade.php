@extends('layouts.frontend.app')

@section('title', __('Payment Successful'))

@section('content')
    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
        <div class="p-card p-4">
            <div class=" image d-flex flex-column justify-content-center align-items-center">
                <button class="p-btn p-btn-secondary">
                    <img src="https://i.imgur.com/wvxPV9S.png" height="100" width="100"/>
                </button>
                <span class="name mt-3">{{ $user->name }}</span>
                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                    <span class="idd">
                        <span>@</span>{{ $user->username }}
                    </span>
                    <span><i class="fa fa-copy"></i></span></div>
                <div class="d-flex flex-row justify-content-center align-items-center mt-3">
                    <span class="number">
                        {{ $user->products()->count() }}
                        <span class="follow">{{ __('Products') }}</span>
                    </span>
                </div>
                @if(isset($plan))
                <div class="text mt-3">
                    <span>
                        {{ $plan->welcome_message }}
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
    <input type="hidden" id="" value="{{ route('users.share', $user->username) }}">
@endsection

@push('css')
    <style>
        .p-card {
            width: 350px;
            background-color: #efefef;
            border: none;
            cursor: pointer;
            transition: all 0.5s;
            margin-top: 80px !important;
        }

        .image img {
            transition: all 0.5s
        }

        .p-card:hover .image img {
            transform: scale(1.5)
        }

        .p-btn {
            height: 140px;
            width: 140px;
            border-radius: 50%
        }

        .name {
            font-size: 22px;
            font-weight: bold
        }

        .idd {
            font-size: 14px;
            font-weight: 600
        }

        .idd1 {
            font-size: 12px
        }

        .number {
            font-size: 22px;
            font-weight: bold
        }

        .follow {
            font-size: 12px;
            font-weight: 500;
            color: #444444
        }
        .text span {
            font-size: 13px;
            color: #545454;
            font-weight: 500
        }

        .icons i {
            font-size: 19px
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
