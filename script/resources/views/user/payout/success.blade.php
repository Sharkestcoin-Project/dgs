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
        <div class="col-sm-10">
            <div class="card radius-card">
                <div class="card-header">
                    <h5 class="text-primary">
                        <a class="btn btn-primary btn-sm rounded-pill" href="{{ route('user.payout.index') }}"><i class="fa fa-backward" aria-hidden="true"></i> {{ __('Back') }}</a>
                        {{ __('An OTP has been sended to your mail. Please check and confirm.') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.payout.success', request('method_id')) }}" method="post" class="makepayout mb-5">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-8 mt-3">
                                <input type="number" class="form-control rounded-custom shadow" name="otp" placeholder="{{ __('OTP') }}" required>
                            </div>
                            <div class="col-3 col-sm-2 mt-3 align-self-center">
                                <button class="btn btn-primary rounded-custom shadow basicbtn">{{ __('Confirm') }} <i class="fas fa-forward"></i></button>
                            </div>
                        </div>
                    </form>
                    @php
                        $method = session('method');
                        $payout_amount = session('payout_amount');
                        $method_charge = session('method_charge');
                        $plan_charge = session('plan_charge');
                        $total_charge = $method_charge + $plan_charge;
                        $available_amount = $payout_amount - $total_charge;
                    @endphp
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Your current balance is') }}</h6>
                        <h6 class="font-weight-bold"> {{ my_balance($method->currency_id) }} </h6>
                    </div>
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Your payout request amount') }}</h6>
                        <h6 class="font-weight-bold">{{ $method->currency->symbol . $payout_amount }}</h6>
                    </div>
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Payout method charge') }}</h6>
                        <h6 class="font-weight-bold">{{ $method->currency->symbol . $method_charge }}</h6>
                    </div>
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Plan payout charge') }}</h6>
                        <h6 class="font-weight-bold">{{ $method->currency->symbol . $plan_charge }}</h6>
                    </div>
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Total charge') }}</h6>
                        <h6 class="font-weight-bold">{{ $method->currency->symbol . $total_charge }}</h6>
                    </div>
                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Avalilable amount') }}</h6>
                        <h6 class="font-weight-bold">{{ $method->currency->symbol . $available_amount }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
