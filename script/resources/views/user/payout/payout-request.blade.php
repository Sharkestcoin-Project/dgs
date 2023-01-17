@extends('layouts.user.app', [
    'prev' => route('user.payout.index')
])

@section('title', __('Make Payout'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card radius-card shadow">
                <div class="card-body">
                    <h5 class="text-primary pb-0">
                        {{ __($method->name) }}
                    </h5>
                    <form action="{{ route('user.payout.get-otp', $method->id) }}" method="post" class="makepayout mb-5">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-8 mt-3">
                                <input type="number" value="{{ $wallet->wallet }}" class="form-control rounded-custom" name="amount" placeholder="{{ __('Payout amount') }}" required step="0.000001">
                            </div>
                            <div class="col-3 col-sm-2 mt-2 align-self-center">
                                <button class="btn btn-primary rounded-custom basicbtn">Go <i class="fas fa-forward"></i></button>
                            </div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between p-1">
                        <h6>{{ __('Available to pay out to you') }}</h6>
                        <h6 class="font-weight-bold">
                            {{ $wallet->currency->symbol.$wallet->wallet }}
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card radius-card">
                <div class="p-3">
                    <h6 class="mb-3">{{ __('Your credentials') }} :-</h6>
                    <div class="row mt-3">
                        @php
                            $fields = json_decode($method->data);
                            $datas = json_decode($usermethod->payout_infos);
                        @endphp
                        <table class="table table-striped">
                        @foreach ($fields as $key => $field)
                            <tr>
                                <td>{{ $field->label }}</td>
                                <td>{{ $datas[$key]->data ?? '' }}</td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                    <h6 class="mb-3">{{ __('Payout method information') }} :-</h6>
                </div>
                <div class="table-responsive pb-4">
                    <table class="table table-hover table-striped">
                        <tr>
                            <th>{{ __('Method name') }}</th>
                            <td>{{ __($method->name) }}</td>
                            <th>{{ __('Currency') }}</th>
                            <td>{{ $method->currency->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Minimum limit') }}</th>
                            <td>{{ $method->min_limit }}</td>
                            <th>{{ __('Maximum limit') }}</th>
                            <td>{{ $method->max_limit }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Charge type') }}</th>
                            <td>{{ $method->percent_charge ? 'Parcentage':'Fixed'  }}</td>
                            <th>{{ __('Charge') }}</th>
                            <td>{{ $method->percent_charge ?? $method->fixed_charge }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Rate') }}</th>
                            <td>{{ $method->currency->rate ?? ''  }}</td>
                            <th>{{ __('Delay') }}</th>
                            <td>{{ $method->delay }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Instraction') }}</th>
                            <td colspan="3">{!! $method->instruction !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
