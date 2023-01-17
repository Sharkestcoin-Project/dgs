@extends('layouts.backend.app')

@section('title', __('Subscription Orders'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Subscription Orders') }}</h4>

            <form class="card-header-form d-flex gap-3">
                <div class="input-group">
                    <input type="text" name="src" value="{{ request('src') }}" class="form-control" placeholder="{{ __('Search by name or email') }}"/>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if($orders->count() > 0 || request('src') !== null)
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap card-table text-center">
                        <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Expire At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody class="list font-size-base rowlink" data-link="row">
                        @foreach($orders as $key => $order)
                            <tr>
                                <td>{{ $order->name  }}</td>
                                <td>
                                    {{ currency_format($order->amount, 'icon', $order->currency->symbol) }}
                                    <sub>/{{ $order->period }}</sub>
                                </td>
                                <td>{{ formatted_date($order->subscription_expire_at) }}</td>
                                <td>
                                    <form action="{{ route('user.subscriptions.orders.renewal', $order->id) }}" method="post" class="ajaxform">
                                        @csrf
                                        <button class="btn btn-primary btn-sm basicbtn">
                                            {{ __('Send Renewal Mail') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found></x-data-not-found>
            @endif
        </div>
        <div class="card-footer">
            {{ $orders->appends(['src' => request('src')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
