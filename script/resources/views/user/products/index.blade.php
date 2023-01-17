@extends('layouts.user.app', [
    'button_name' => __('Add New'),
    'button_link' => route('user.products.create')
])

@section('title', __('Products'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Seller Products') }}</h4>
            <form action="{{ route('user.products.index') }}" class="card-header-form">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('Search by Name') }}">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive product-table">
                    <table class="table table-stripped">
                        <thead>
                        <tr>
                            <th>{{ __('Cover') }}</th>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('File Size') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Color') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <figure class="avatar avatar-sm">
                                        <img src="{{ asset($product->cover) }}" alt="{{ $product->name }}">
                                    </figure>
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ human_filesize($product->size) }}</td>
                                <td>{{ currency_format($product->price, 'icon', $product->currency->symbol) }}</td>
                                <td>
                                    <span style="background-color: {{ $product->theme_color }}">{{ $product->theme_color }}</span>
                                </td>
                                <td>
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ __('Action') }}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item has-icon" href="{{ route('user.products.show', $product->id) }}"><i class="fa fa-eye"></i> {{ __('View') }}</a>
                                            <a class="dropdown-item has-icon" href="{{ route('user.products.edit', $product->id) }}"><i class="fas fa-edit"></i></i> {{ __('Edit') }}</a>
                                            <a class="dropdown-item has-icon" href="{{ route('user.product.iframe', $product->id) }}"><i class="far fa-file-code"></i> {{ __('Embed') }}</a>
                                            <a class="dropdown-item has-icon" href="{{ route('products.show', $product->id) }}"><i class="far fa-grin-beam"></i> {{ __('View product') }}</a>
                                            <a class="dropdown-item has-icon delete-confirm" href="#" data-action="{{ route('user.products.destroy', $product->id) }}"><i class="fas fa-trash"></i> {{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found
                    message="You don't have any product! Create Product and sell it."
                    help=""
                    button_name="{{ __('Create Product') }}"
                    button_link="{{ route('user.products.create') }}"
                ></x-data-not-found>
            @endif
        </div>
    </div>
@endsection
