@extends('layouts.frontend.app')

@section('title', __('Make Payment'))

@section('content')
<div class="single-product-page-area">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="px-4">
                            <table class="table">
                                <tr>
                                    <td>{{ __('Amount') }}</td>
                                    <td class="float-right">{{ currency_format($Info['main_amount']) }}</td>
                                </tr>
                                @if(!session('without_tax'))
                                <tr>
                                    <td>{{ __('Taxes') }}</td>
                                    <td class="float-right">{{ currency_format(calculate_taxes($Info['main_amount'], false)) }}</td>
                                </tr>
                                @endif

                                <tr>
                                    <td>{{ __('Charge') }}</td>
                                    <td class="float-right">{{ currency_format(calculate_gateway_charge($gateway)) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Total') }}</td>
                                    <td class="float-right">{{ currency_format((session('without_tax') ? $Info['main_amount'] : calculate_taxes($Info['main_amount'])) + calculate_gateway_charge($gateway)) }}</td>
                                </tr>

                                <tr>
                                    <td>{{ __('Payable') }} ({{ $Info['currency'] }})</td>
                                    <td class="float-right">{{ currency_format(payable($Info['main_amount'], $gateway, session('without_tax')), 'icon', $gateway->currency->symbol) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Payment Mode') }}</td>
                                    <td class="float-right">{{ __('PayStack') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-primary mt-4 col-12 w-100 btn-lg" id="payment_btn">{{ __('Pay Now') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<form method="post" class="status" action="{{ route('user.paystack.status') }}">
    @csrf
    <input type="hidden" name="ref_id" id="ref_id">
    <input type="hidden" value="{{ $Info['currency'] }}" id="currency">
    <input type="hidden" value="{{ $Info['amount'] }}" id="amount">
    <input type="hidden" value="{{ $Info['public_key'] }}" id="public_key">
    <input type="hidden" value="{{ $Info['email'] ?? Auth::user()->email }}" id="email">
</form>
@endsection


@push('script')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    "use strict";

    $('#payment_btn').on('click',()=>{
        payWithPaystack();
    });
   payWithPaystack();

    function payWithPaystack() {
        var amont= $('#amount').val() * 100 ;
        let handler = PaystackPop.setup({
            key: $('#public_key').val(), // Replace with your public key
            email: $('#email').val(),
            amount: amont,
            currency: $('#currency').val(),
            ref: 'ps_{{ Str::random(15) }}',
            onClose: function(){
                payWithPaystack();
            },
            callback: function(response){
                $('#ref_id').val(response.reference);
                $('.status').submit();
            }
        });
        handler.openIframe();
    }
</script>
@endpush
