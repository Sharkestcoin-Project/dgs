@extends('layouts.backend.app', [
    'button_name' => Auth::user()->plan->sell_subscription ? __('Add New Subscription') : __("Upgrade Now"),
    'button_link' => Auth::user()->plan->sell_subscription ? route('user.subscriptions.create') : route('user.settings.subscriptions.index')
])

@section('title', __('Subscriptions'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Subscriptions') }}</h4>

            <form class="card-header-form d-flex gap-3">
                <div class="input-group">
                    <input type="text" name="src" value="{{ request('src') }}" class="form-control" placeholder="{{ __('Search by name') }}"/>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('user.subscriptions.destroy.mass') }}" class="ajaxform_with_mass_delete">
                @csrf
                @if(count($plans) > 0 || request('src') !== null)
                    <div class="float-left">
                        <button class="btn btn-danger btn-lg basicbtn mass-delete-btn d-none" id="submit-button">{{ __('Delete') }}</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap card-table text-center">
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="list font-size-base rowlink" data-link="row">
                            @foreach($plans as $key => $plan)
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" name="id[]" id="plan-{{ $plan->id }}"
                                                   class="custom-control-input checked_input"
                                                   value="{{ $plan->id }}" data-checkboxes="mygroup">
                                            <label for="plan-{{ $plan->id }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $plan->name  }}</td>
                                    <td>{{ currency_format($plan->price, 'icon', $plan->currency->symbol) }}<sub>/{{ $plan->period }}</sub></td>
                                    <td>{{ str($plan->description)->words(10) }}</td>
                                    <td>
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton2" data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                            {{ __('Action') }}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item has-icon" href="{{ route('user.subscription.iframe', $plan->id) }}">
                                                <i class="fa fa-file-code"></i>
                                                {{ __('Embed') }}
                                            </a>

                                            <a class="dropdown-item has-icon"
                                               href="{{ route('user.subscriptions.edit',$plan->id) }}">
                                                <i class="fa fa-edit"></i>
                                                {{ __('Edit') }}
                                            </a>

                                            <a class="dropdown-item has-icon delete-confirm"
                                               href="javascript:void(0)"
                                               data-action={{ route('user.subscriptions.destroy', $plan->id) }}>
                                                <i class="fa fa-trash"></i>
                                                {{ __('Delete') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @if(Auth::user()->plan->sell_subscription)
                        <x-data-not-found></x-data-not-found>
                    @else
                        <x-data-not-found
                            :message="__('Please Upgrade Your Subscription')"
                            :button_name="__('Upgrade Now')"
                            :button_link="route('user.settings.subscriptions.index')"
                            help=""

                        ></x-data-not-found>
                    @endif
                @endif
            </form>
        </div>
        <div class="card-footer">
            @if(count($plans) > 0)
                {{ $plans->appends(['src' => request('src')])->links('vendor.pagination.bootstrap-4') }}
            @endif
        </div>
    </div>
@endsection
