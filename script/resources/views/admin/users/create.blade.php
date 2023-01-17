@extends('layouts.backend.app', [
    'prev' => route('admin.users.index')
])

@section('title', __('Create User'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Create User') }}</h4>
                </div>
                <div class="card-body overflow-auto max-h-550">
                    <form method="POST" action="{{ route('admin.users.store') }}" class="ajaxform_with_redirect">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="name" class="required mb-0">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Enter full name') }}" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="email" class="required mb-0">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Enter email address') }}" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="phone" class="required mb-0">{{ __('Phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="form-control" placeholder="{{ __('Enter phone number') }}" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="password" class="required mb-0">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control" min="8" placeholder="{{ __('Enter password') }}" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="status" class="required mb-0">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control" data-control="select2" required>
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                            <div class="col-sm-6 align-self-center text-center">
                                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    {{ __('Add More') }} ({{ __('Optional') }})
                                </a>
                            </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="plan" class="optional mb-0">{{ __('Plan') }}</label>
                                    <select name="plan" id="plan" class="form-control" data-control="select2" data-allow-clear="true" data-placeholder="{{ __('Select a subscription plan') }}">
                                        <option></option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->name }} ({{ currency_format($plan->price) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="gateway" class="required mb-0">{{ __('Gateway') }}</label>
                                    <select name="gateway" id="gateway" class="form-control" data-control="select2" data-placeholder="{{ __('Select a payment gateway') }}">
                                        <option></option>
                                        @foreach ($gateways as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="trx" class="required mb-0">{{ __('Transaction ID') }}</label>
                                    <input type="text" name="trx" id="trx" class="form-control" placeholder="{{ __('Enter trx') }}">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="paid_status" class="required mb-0">{{ __('Paid Status') }}</label>
                                    <select name="paid_status" id="paid_status" class="form-control" data-control="select2" data-placeholder="{{ __('Select Paid Status') }}">
                                        <option value="1">{{ __('Approved') }}</option>
                                        <option value="2">{{ __('Pending') }}</option>
                                        <option value="0">{{ __('Failed') }}</option>
                                        <option value="3">{{ __('Expired') }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="payment_status" class="required mb-0">{{ __('Payment Status') }}</label>
                                    <select name="payment_status" id="payment_status" class="form-control" data-control="select2" data-placeholder="{{ __('Select Payment Status') }}">
                                        <option value="1">{{ __('Approved') }}</option>
                                        <option value="2">{{ __('Pending') }}</option>
                                        <option value="0">{{ __('Failed') }}</option>
                                        <option value="3">{{ __('Expired') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary float-right basicbtn">
                                <i class="fas fa-save"> </i>
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        $('#plan').on('change.select2', function(e){
            var id = $(this).val();

            if(id === ""){
                $('#plan-dependent-inputs').hide();
                $('#gateway').val(null).trigger('change');
                $('#trx').val(null);

                $('#gateway').attr('required', false);
                $('#trx').attr('required', false);
                $('#paid_status').attr('required', false);
                $('#payment_status').attr('required', false);
            }else {
                $('#plan-dependent-inputs').show();
                $('#gateway').attr('required', true);
                $('#trx').attr('required', true);
                $('#paid_status').attr('required', true);
                $('#payment_status').attr('required', true);
            }
        })
    </script>
@endpush
