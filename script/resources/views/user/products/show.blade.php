@extends('layouts.user.app', [
    'prev' => route('user.products.index')
])

@section('title', __('Product details'))

@section('content')
    <div class="row product-show">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>{{ __('Cover') }}</th>
                                    <td>
                                        <figure class="avatar avatar-sm">
                                            <img src="{{ asset($product->cover) }}" alt="{{ $product->name }}">
                                        </figure>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Product Name') }}</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                @if ($product->file)
                                <tr>
                                    <th>{{ __('File') }}</th>
                                    <td>
                                        <a href="{{ route('user.products.download', $product->id) }}" class="btn btn-primary btn-sm w-100" download>
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            {{ __('Download') }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('File Size') }}</th>
                                    <td>{{ human_filesize($product->size) }}</td>
                                </tr>
                                @else
                                <tr>
                                    <tr>
                                        <th>{{ __('File Link') }}</th>
                                        <td><a href="{{ $product->meta['direct_url'] ?? '' }}">{{ $product->meta['direct_url'] ?? '' }}</a></td>
                                    </tr>
                                </tr>
                                @endif
                                <tr>
                                    <th>{{ __('Price') }}</th>
                                    <td>{{ currency_format($product->price) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Color') }}</th>
                                    <td>
                                        <span style="background-color: {{ $product->theme_color }}">{{ $product->theme_color }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Buyer can set price') }}</th>
                                    <td>
                                        <div class="badge {{ $product->buyer_can_set_price ?  'badge-success':'badge-primary' }}">
                                            {{ $product->buyer_can_set_price ?  __('Yes'):__('No') }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Notifiable') }}</th>
                                    <td>
                                        <div class="badge {{ $product->notify_previous_buyer ?  'badge-success':'badge-primary' }}">
                                            {{ $product->notify_previous_buyer ?  __('Yes'):__('No') }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Return url') }}</th>
                                    <td><a href="{{ $product->return_url }}">{{ $product->return_url }}</a></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h6>{{ __('Currency Infos') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Rate') }}</th>
                                    <th>{{ __('Symbol') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $product->currency->name ?? '' }}</td>
                                    <td>{{ $product->currency->code ?? '' }}</td>
                                    <td>{{ $product->currency->rate ?? '' }}</td>
                                    <td>{{ $product->currency->symbol ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
