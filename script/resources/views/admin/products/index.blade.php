@extends('layouts.backend.app')

@section('title', __('Products'))

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('Products list') }}</h4>
            <form action="{{ route('admin.products.index') }}" class="card-header-form">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('Search by Name') }}">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive product-table">
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>{{ __('Cover') }}</th>
                        <th>{{ __('Product Name') }}</th>
                        <th>{{ __('File Size') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Color') }}</th>
                        <th>{{ __('Created At') }}</th>
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
                            <td>{{ formatted_date($product->created_at) }}</td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon" href="{{ route('admin.products.show', $product->id) }}"><i class="fa fa-eye"></i> {{ __('View') }}</a>
                                        <a class="dropdown-item has-icon" href="{{ route('products.show', $product->id) }}"><i class="far fa-grin-beam"></i> {{ __('View product') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm" href="#" data-action="{{ route('admin.products.destroy', $product->id) }}"><i class="fas fa-trash"></i> {{ __('Delete') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
