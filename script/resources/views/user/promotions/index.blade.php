@extends('layouts.user.app', [
    'button_name' => __('Add New'),
    'button_link' => route('user.promotions.create')
])

@section('title', __('Promotions'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Product Promotions') }}</h4>
            <form class="card-header-form">
                <div class="input-group">
                    <input type="text" name="src" value="{{ request('src') }}" class="form-control" placeholder="{{ __('Search') }}"/>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if($promotions->count() > 0)
                <form method="post" action="{{ route('user.promotions.destroy.mass') }}" class="ajaxform_with_mass_delete">
                    @csrf
                    <div class="float-left">
                        <button class="btn btn-danger btn-lg basicbtn mass-delete-btn d-none" id="submit-button">
                            <i class="fas fa-trash"></i>
                            {{ __('Delete') }}
                        </button>
                    </div>

                    <div class="clearfix mb-3"></div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center pt-2">
                                    <div class="custom-checkbox custom-checkbox-table custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup"
                                               data-checkbox-role="dad" class="custom-control-input"
                                               id="checkbox-all">
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($promotions as $promotion)
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" name="id[]" id="promotion-{{ $promotion->id }}"
                                                   class="custom-control-input checked_input"
                                                   value="{{ $promotion->id }}" data-checkboxes="mygroup">
                                            <label for="promotion-{{ $promotion->id }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td><a href="{{ route('user.products.show', $promotion->product_id) }}">{{ $promotion->product->name }}</a></td>
                                    <td>{{ $promotion->code }}</td>
                                    <td>{{ $promotion->is_percent ? $promotion->discount : currency_format($promotion->discount) }} @if($promotion->is_percent) % @endif</td>
                                    <td class="text-right">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ __('Action') }}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a
                                                href="{{ route('user.promotions.edit', $promotion->id) }}"
                                                class="dropdown-item has-icon"
                                            >
                                                <i class="fas fa-edit"></i>
                                                {{ __('Edit') }}
                                            </a>
                                            <a
                                                href="javascript:void(0)"
                                                data-action="{{ route('user.promotions.destroy', $promotion->id) }}"
                                                class="dropdown-item has-icon delete-confirm"
                                            >
                                                <i class="fas fa-trash"></i>
                                                {{ __('Delete') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            @else
                <x-data-not-found :message="__(`We couldn't find any prmotion`)" :help="false"></x-data-not-found>
            @endif
        </div>
    </div>
@endsection
