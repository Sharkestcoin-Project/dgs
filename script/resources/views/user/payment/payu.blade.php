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
                                    <td class="float-right">{{ __('Payu') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <form action="#" method="post" name="payuForm" id="payment_form">
                        @csrf
                        <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
                        <input type="hidden" id="salt" value="{{ $Info['salt'] }}" />
                        <input type="hidden" name="key" id="key" value="{{ $Info['key'] }}" />
                        <input type="hidden" name="hash" id="hash" value="{{ $Info['hash'] }}"/>
                        <input type="hidden" name="txnid" id="txnid" value="{{ $Info['txnid'] }}" />
                        <input type="hidden" name="amount" id="amount" value="{{ $Info['amount'] }}" />
                        <input type="hidden" name="firstname" id="firstname" value="{{ $Info['firstname'] }}"/>
                        <input type="hidden" name="email" id="email" value="{{ $Info['email'] }}" />
                        <input type="hidden" name="phone" id="mobile" value="{{ $Info['phone'] }}" />
                        <input type="hidden" name="productinfo" id="productinfo" value="{{ $Info['productinfo'] }}"/>
                        <input type="hidden" name="surl" id="surl" value="{{ $Info['surl'] }}"/>
                        <input type="hidden" name="furl" id="furl" value="{{ $Info['furl'] }}"/>
                        <div class="card-footer bg-white">
                            <input type="submit" class="btn btn-primary mt-4 col-12 w-100 btn-lg" value="Submit" onclick="launchBOLT(); return false;"/>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@if ($Info['test_mode'] == true)
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-
color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@else
<script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@endif
<script>
    "use strict";
    launchBOLT();
    function launchBOLT()
    {
        var salt = $('#salt').val();
        var surl = $('#surl').val();
        bolt.launch({
            key: $('#key').val(),
            txnid: $('#txnid').val(),
            hash: $('#hash').val(),
            amount: $('#amount').val(),
            firstname: $('#firstname').val(),
            email: $('#email').val(),
            phone: $('#mobile').val(),
            productinfo: $('#productinfo').val(),
            udf5: $('#udf5').val(),
            surl : $('#surl').val(),
            furl: $('#surl').val(),
            mode: 'dropout'
        },{ responseHandler: function(BOLT){
                console.log( BOLT.response.txnStatus );
                if(BOLT.response.txnStatus != 'CANCEL')
                {
                    // Salt is passd here for demo purpose only. For practical use keep salt at server side only.
                    var fr = '<form action=\"'+surl+'\" method=\"post\">' +
                        '<input type=\"hidden\" name=\"key\" value=\"'+BOLT.response.key+'\" />' +
                        '<input type=\"hidden\" name=\"salt\" value=\"'+ salt +'\" />' +
                        '<input type=\"hidden\" name=\"txnid\" value=\"'+BOLT.response.txnid+'\" />' +
                        '<input type=\"hidden\" name=\"amount\" value=\"'+BOLT.response.amount+'\" />' +
                        '<input type=\"hidden\" name=\"productinfo\" value=\"'+BOLT.response.productinfo+'\" />' +
                        '<input type=\"hidden\" name=\"firstname\" value=\"'+BOLT.response.firstname+'\" />' +
                        '<input type=\"hidden\" name=\"email\" value=\"'+BOLT.response.email+'\" />' +
                        '<input type=\"hidden\" name=\"udf5\" value=\"'+BOLT.response.udf5+'\" />' +
                        '<input type=\"hidden\" name=\"mihpayid\" value=\"'+BOLT.response.mihpayid+'\" />' +
                        '<input type=\"hidden\" name=\"status\" value=\"'+BOLT.response.status+'\" />' +
                        '<input type=\"hidden\" name=\"hash\" value=\"'+BOLT.response.hash+'\" />' +
                        '</form>';
                    var form = jQuery(fr);
                    jQuery('body').append(form);
                    form.submit();
                }
            },
            catchException: function(BOLT){
                alert( BOLT.message );
            }
        });
    }
</script>
@endpush
