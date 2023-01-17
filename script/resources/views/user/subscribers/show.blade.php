@extends('layouts.backend.app')

@section('title', __('Orders'))

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ get_gravatar($subscriber->email) }}" alt="{{ $subscriber->name }}" class="card-img-top">
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <td>{{ $subscriber->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Email') }}</th>
                            <td>{{ $subscriber->email }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Phone') }}</th>
                            <td>{{ $subscriber->phone }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>{{ __('Invoice') }}</th>
                            <th>{{ __('Plan') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Gateway') }}</th>
                            <th>{{ __('Expire At') }}</th>
                            <th>{{ __('Renew') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscriber->orders as $order)
                            <tr class="text-center">
                                <td>{{ $order->invoice_no }}</td>
                                <td>{{ $order->plan->name }}</td>
                                <td>
                                    {{ currency_format($order->amount, 'icon', $order->currency->symbol) }}
                                    <sub>/{{ $order->period }}</sub>
                                </td>
                                <td>
                                    <img src="{{ $order->gateway->logo }}" alt="{{ $order->gateway->name }}" width="100">
                                </td>
                                <td>{{ formatted_date($order->subscription_expire_at) }}</td>
                                <td>
                                    @if($order->is_open)
                                    <form action="{{ route('user.subscribers.renewal', $order->id) }}" method="post" class="ajaxform">
                                        @csrf
                                        <button class="btn btn-primary btn-sm basicbtn">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
