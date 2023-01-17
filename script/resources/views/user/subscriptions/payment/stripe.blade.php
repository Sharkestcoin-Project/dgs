@extends('layouts.frontend.product')

@section('title', __('Stripe Payment'))

@section('content')
    <!-- Single Product Page Area -->
    <div class="single-product-page-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="px-4">
                                <table class="table">
                                    <tr>
                                        <th>{{ __('Price') }}</th>
                                        <td>
                                            {{ currency_format($plan->price, 'icon', default_currency('symbol')) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('Gateway Charge') }}</th>
                                        <td>
                                            {{ currency_format(calculate_gateway_charge($gateway)) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('Total') }}</th>
                                        <td>{{ currency_format($plan->price + calculate_gateway_charge($gateway)) }}</td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('Gateway Rate') }}</th>
                                        <td>{{ $gateway->currency->rate  }}</td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('Payable') }} ({{ $gateway->currency->code }})</th>
                                        <td>
                                            {{ currency_format(payable($plan->price, $gateway, true), 'icon', $gateway->currency->symbol) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Payment Mode') }}</td>
                                        <td class="float-right">{{ __('Stripe') }}</td>
                                    </tr>
                                </table>

                                <form action="{{ Session::get('without_auth') ? url('stripe/payment') : url('user/stripe/payment') }}" method="post" id="payment-form" class="paymentform p-4">
                                    @csrf
                                    <div class="form-row">
                                        <label for="card-element">
                                            {{ __('Credit or debit card') }}
                                        </label>
                                        <div id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                        </div>
                                        <!-- Used to display form errors. -->
                                        <div id="card-errors" role="alert"></div>
                                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4" id="submit_btn">{{ __('Submit Payment') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<input type="hidden" id="publishable_key" value="{{ $Info['publishable_key'] }}">

@endsection

@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        "use strict";
        var stripe_key = $('#publishable_key').val();
        var publishable_key = stripe_key;
        // Create a Stripe client.
        var stripe = Stripe(publishable_key);

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
@endpush
