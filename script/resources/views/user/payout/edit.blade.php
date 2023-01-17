@extends('layouts.user.app')

@section('title', 'Payout edit')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card radius-card">
                <div class="card-header">
                    <h5 class="text-primary pb-0">
                        <a class="btn btn-primary btn-sm rounded-pill" href="{{ route('user.payout.index') }}"><i class="fa fa-backward" aria-hidden="true"></i> {{ __('Back') }}</a> &nbsp;
                        {{ __($method->name) }}
                    </h5>
                </div>
                <div class="table-responsive">
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
                            <td>{{ $method->rate  }}</td>
                            <th>{{ __('Delay') }}</th>
                            <td>{{ $method->delay }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Instraction') }}</th>
                            <td colspan="3">{!! $method->instruction !!}</td>
                        </tr>
                    </table>
                </div>

                <div class="p-3 pb-4">
                    <h6 class="mb-3">{{ __('Update yourself') }} :-</h6>
                    <form action="{{ route('user.payout.update', $method->id) }}" method="post" class="ajaxform">
                        @csrf

                        <div class="row mt-3">
                            @php
                                $fields = json_decode($method->data);
                                $datas = json_decode($usermethod->payout_infos);
                            @endphp
                            @foreach ($fields as $key => $field)
                            <div class="col-sm-6 mt-3">
                                <label for="">{{ $field->label ?? '' }}</label>
                                <input type="{{ $field->type ?? '' }}" class="form-control rounded-custom" value="{{ $datas[$key]->data ?? '' }}" name="inputs[{{$key}}][data]" placeholder="{{ __('Write here...') }}">
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col text-right mt-3">
                                <button class="btn btn-primary rounded-pill basicbtn"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
