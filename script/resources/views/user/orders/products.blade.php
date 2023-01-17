@extends('layouts.backend.app')

@section('title', __('Product Orders'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Product Orders') }}</h4>
            <form class="card-header-form">
                <div class="input-group">
                    <input type="text" name="src" value="{{ request('src') }}" class="form-control" placeholder="{{ __('Search by email or Cuppon') }}"/>
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
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Download Link') }}</th>
                        </tr>
                        </thead>
                        <tbody class="list font-size-base rowlink" data-link="row">
                        @foreach($orders as $key => $order)
                            <tr>
                                <td>{{ formatted_date($order->created_at) }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ currency_format($order->amount) }}</td>
                                <td>
                                    <form action="{{ route('user.orders.products.resend', $order->id) }}" method="post" class="ajaxform">
                                        @csrf
                                        @method('put')
                                        <button class="btn btn-primary btn-sm basicbtn">{{ __('Resend') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found :message="__(`Once you've sold a product you'll see your order history here 😊`)"></x-data-not-found>
            @endif
        </div>
        <div class="card-footer">
            {{ $orders->appends(['src' => request('src')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
