@extends('layouts.backend.app')

@section('title', __('Subscription Orders'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Subscription Orders') }}</h4>
            <form class="card-header-form">
                <div class="input-group">
                    <input type="text" name="src" value="{{ request('src') }}" class="form-control" placeholder="{{ __('Search by name, email or phone') }}"/>
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
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Plan') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Order At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody class="list font-size-base rowlink" data-link="row">
                        @foreach($orders as $key => $order)
                            <tr>
                                <td>{{ $order->subscriber->name }}</td>
                                <td>{{ $order->subscriber->email }}</td>
                                <td>{{ $order->subscriber->phone }}</td>
                                <td>{{ $order->plan->name }}</td>
                                <td>{{ currency_format($order->amount, 'icon', $order->currency->icon) }}</td>
                                <td>{{ formatted_date($order->created_at) }}</td>
                                <td>
                                    <a href="{{ route('user.orders.subscriptions.show', $order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found :message="__(`Once you've sold a subscription you'll see your order history here 😊`)"></x-data-not-found>
            @endif
        </div>
        <div class="card-footer">
            {{ $orders->appends(['src' => request('src')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
