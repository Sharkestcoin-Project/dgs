@extends('layouts.user.app', [
    'prev' => route('user.promotions.index')
])

@section('title', __('Add Promotion'))

@section('content')
    <form action="{{ route('user.promotions.store') }}" method="post" class="ajaxform_with_redirect">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="products" class="required">{{ __('Product') }}</label>
                            <select name="products[]" id="products" class="selectric" multiple required>
                                <option disabled>{{ __("Select Products") }}</option>
                                @foreach($products as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="discount" class="required">{{ __('Discount') }}</label>
                            <div class="input-group mb-3">
                                <input type="number" name="discount" id="discount" class="form-control" placeholder="{{ __('Enter Discount') }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="code" class="required">{{ __('Code') }}</label>
                            <input type="text" name="code" id="code" minlength="4" class="form-control" placeholder="{{ __('15DB88ER') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="max_limit" class="required">{{ __('Maximum Redemption') }}</label>
                            <input type="number" name="max_limit" id="max_limit" class="form-control" placeholder="{{ __('Enter Maximum Redemption Limit') }}" required>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary float-right basicbtn">
                                <i class="fas fa-save"></i>
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
