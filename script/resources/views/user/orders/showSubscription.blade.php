@extends('layouts.backend.app')

@section('title', __('Subscription Orders'))

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset($order->plan->cover) }}" alt="" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ __('Subscription Information') }}
                    </h5>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>{{ __('Plan Name') }}</th>
                            <td>{{ $order->plan->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Plan Price') }}</th>
                            <td>{{ currency_format($order->plan->price, 'icon', $order->currency->icon) }} <sub>/{{ $order->plan->period }}</sub></td>
                        </tr>
                        <tr>
                            <th>{{ __('Plan Description') }}</th>
                            <td>{{ $order->plan->description }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ __('Order Information') }}
                    </h5>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>{{ __('Customer Name') }}</th>
                            <td>{{ $order->subscriber->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Customer Email') }}</th>
                            <td>{{ $order->subscriber->email }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Customer Phone') }}</th>
                            <td>{{ $order->subscriber->phone }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Price') }}</th>
                            <td>{{ currency_format($order->amount, 'icon', $order->icon) }} <sub>/{{ $order->period }}</sub></td>
                        </tr>
                        <tr>
                            <th>{{ __('TRX No') }}</th>
                            <td>{{ $order->trx }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Invoice No') }}</th>
                            <td>{{ $order->invoice_no }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Expire At') }}</th>
                            <td>{{ formatted_date($order->subscription_expire_at) }}</td>
                        </tr>
                        @if($order->is_open)
                        <tr>
                            <th>{{ __('Resend Invoice') }}</th>
                            <td>
                                <a
                                    class="btn btn-success confirm-action"
                                    href="javascript:void(0)"
                                    data-action="{{ route('user.orders.subscriptions.resend', $order->id) }}"
                                    data-method="PUT"
                                >
                                    {{ __('Send Now') }}
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
