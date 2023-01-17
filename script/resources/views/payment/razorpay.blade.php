@extends('layouts.frontend.product')

@section('title', __('RazorPay Payment'))

@section('content')
<div class="single-product-page-area">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <img  src="{{ asset($gateway->logo) }}" alt="" height="100" class="text-center">
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
                                    <td class="float-right">{{ __('RazorPay') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-primary mt-4 col-12 btn-lg w-100" id="rzp-button1">{{ __('Pay Now') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ Session::get('without_auth') ? url('razorpay/status') : url('/user/razorpay/status') }}" method="POST" hidden>
    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
    <input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
    <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
    <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
    <button type="submit" id="rzp-paymentresponse" hidden class="btn btn-primary"></button>
</form>

<input type="hidden" value="{{ $response['razorpayId'] }}" id="razorpayId">
<input type="hidden" value="{{ $response['amount'] }}" id="amount">
<input type="hidden" value="{{ $response['currency'] }}" id="currency">
<input type="hidden" value="{{ $response['name'] }}" id="name">
<input type="hidden" value="{{ $response['description'] }}" id="description">
<input type="hidden" value="{{ $response['orderId'] }}" id="orderId">
<input type="hidden" value="{{ $response['name'] }}" id="name">
<input type="hidden" value="{{ $response['email'] }}" id="email">
<input type="hidden" value="{{ $response['contactNumber'] }}" id="contactNumber">
<input type="hidden" value="{{ $response['address'] }}" id="address">
@endsection

@push('script')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        "use strict";
        /*------------------------------
                Razorpay Intergration
            --------------------------------*/
        var logo = document.getElementById('logo');
        var options = {
            "key": $('#razorpayId').val(), // Enter the Key ID generated from the Dashboard
            "amount": $('#amount').val(), // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            "currency": $('#currency').val(),
            "name": $('#name').val(),
            "description": $('#description').val(),
            "image": logo, // You can give your logo url
            "order_id": $('#orderId').val(), //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "handler": function (response){
                // After payment successfully made response will come here
                // send this response to Controller for update the payment response
                // Create a form for send this data
                // Set the data in form
                document.getElementById('rzp_paymentid').value = response.razorpay_payment_id;
                document.getElementById('rzp_orderid').value = response.razorpay_order_id;
                document.getElementById('rzp_signature').value = response.razorpay_signature;

                // // Let's submit the form automatically
                document.getElementById('rzp-paymentresponse').click();
            },
            "prefill": {
                "name": $('#name').val(),
                "email": $('#email').val(),
                "contact": $('#contactNumber').val()
            },
            "notes": {
                "address": $('#address').val()
            },
            "theme": {
                "color": "#F37254"
            }
        };
        var rzp1 = new Razorpay(options);
        window.onload = function(){
            document.getElementById('rzp-button1').click();
        };

        document.getElementById('rzp-button1').onclick = function(e){
            rzp1.open();
            e.preventDefault();
        }

    </script>
@endpush
