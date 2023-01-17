@extends('layouts.frontend.product')

@section('title', __('PayStack Payment'))

@section('content')
    <div class="single-product-page-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="px-4">
                                <table class="table">
                                    <tr>
                                        <th>{{ __('Product Price') }}</th>
                                        <td>
                                            {{ currency_format(convert_money($product->price, $product->currency)) }}
                                        </td>
                                    </tr>

                                    @if(!session('without_tax'))
                                        <tr>
                                            <td>{{ __('Taxes') }}</td>
                                            <td class="float-right">{{ currency_format(calculate_taxes($Info['main_amount'], false)) }}</td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <th>{{ __('Gateway Charge') }}</th>
                                        <td>
                                            {{ currency_format(calculate_gateway_charge($gateway)) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('Total') }}</th>
                                        <td>{{ currency_format(convert_money($product->price, $product->currency) + calculate_gateway_charge($gateway)) }}</td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('Gateway Rate') }}</th>
                                        <td>{{ $gateway->currency->rate  }}</td>
                                    </tr>

                                    @if(Session::has('promotion'))
                                        <tr>
                                            <th>{{ __('Discount') }} {{ $promotion->is_percent ? '('.$promotion->discount.'%)' : null }}</th>
                                            <td>
                                                {{ $promotion->is_percent ? currency_format((convert_money($product->price, $product->currency) * $promotion->discount) / 100) : currency_format($promotion->discount) }}
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <th>{{ __('Payable') }} ({{ $gateway->currency->code }})</th>
                                        <td>
                                            @php
                                                if (Session::has('promotion')){
                                                   $discount = $promotion->is_percent ? (convert_money($product->price, $product->currency) * $promotion->discount) / 100 : $promotion->discount;
                                                }else{
                                                    $discount = 0;
                                                }
                                            @endphp
                                            {{ currency_format(payable(convert_money($product->price, $product->currency) - $discount, $gateway, true), 'icon', $gateway->currency->symbol) }}
                                        </td>
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

@if(Session::get('without_auth'))
    <form method="post" class="status" action="{{ route('paystack.status') }}">
@else
    <form method="post" class="status" action="{{ route('user.paystack.status') }}">
@endif
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
