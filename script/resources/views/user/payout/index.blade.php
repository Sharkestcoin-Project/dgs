@extends('layouts.user.app')

@section('title', __('Payout Methods'))

@section('content')
    <div class="row justify-content-center">
        @if (session('success_msg'))
            <div class="col-8">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <strong>{{ __('Success!') }}</strong> {{ session('success_msg') }}
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="col-8">
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <strong>{{ __('Error!') }}</strong> {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="col-sm-9">
            <div class="card custom-border">
                <div class="card-header">
                    <h4 class="section-title">{{ __('Your balance') }}</h4>
                </div>
                <div class="card-body">
                    @foreach ($wallets as $wallet)
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Available to pay out to you') }} ({{ $wallet->currency->code ?? '' }})</h6>
                        <h6 class="font-weight-bold">{{ $wallet->currency->symbol.($wallet->wallet ?? 0) }}</h6>
                    </div>
                    @endforeach
                    @foreach ($pending_amounts as $pending_amount)
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Currently on the way to your bank account') }} ({{ $pending_amount->currency->code }})</h6>
                        <h6 class="font-weight-bold">{{ $pending_amount->currency->symbol . $pending_amount->amount }}</h6>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @foreach ($methods as $method)
        <div class="col-sm-9">
            <div class="card custom-border">
                <div class="card-header">
                    <h4 class="section-title">{{ __('Receive payments directly with '.$method->name) }}</h4>
                </div>
                <div class="card-body">
                    @if ($method->usermethod)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between p-1">
                            <h6>{{ __('Supported currency') }}</h6>
                            <h6> {{ $method->currency->name ?? '' }} </h6>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-8">
                            <h5>{{ $method->usermethod ? __('Account connected'):__('Account not connected') }}</h5>
                        </div>
                        @if ($method->usermethod)
                        <div class="col-4 text-right">
                            <a class="white-custom-btn" href="{{ route('user.payout.edit', $method->id) }}"><i class="fas fa-edit"></i></a>
                        </div>
                        @endif
                    </div>
                    @if ($method->data && $method->usermethod && optional($method->usermethod)->payout_infos == null)
                        <a class="btn btn-warning btn-lg rounded btn-sm mt-2" href="{{ route('user.payout.edit', $method->id) }}">
                            {{ __('Please edit with your credintials') }}
                        </a>
                    @elseif ($method->usermethod)
                        <a class="btn btn-primary btn-lg rounded btn-sm mt-2" href="{{ route('user.payout.make-payout', $method->id) }}">
                            {{ __('Make payout') }}
                        </a>
                    @endif
                    @if (!$method->usermethod)
                        <a class="btn btn-primary btn-lg rounded btn-sm mt-2" href="{{ route('user.payout.setup', $method->id) }}">
                            {{ __('Set up') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
