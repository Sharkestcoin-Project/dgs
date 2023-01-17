@extends('layouts.backend.app', [
    'button_name' => __('Create New'),
    'button_link' => route('admin.plans.create')
])

@section('title', __('Plans'))

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.plans.destroy.mass') }}" class="ajaxform_with_mass_delete">
                            @csrf
                            <div class="float-left">
                                <button class="btn btn-danger btn-lg basicbtn mass-delete-btn d-none" id="submit-button">{{ __('Delete') }}</button>
                            </div>

                            <div class="float-right">
                                <a href="{{ route('admin.plans.index') }}"
                                   class="mr-2 btn btn-outline-primary  {{ request('type') == null ? 'active' : '' }} ">
                                    {{ __('All') }} ({{$all}})
                                </a>
                                <a href="{{ route('admin.plans.index', ['type' => 'active']) }}"
                                   class="mr-2 btn btn-outline-primary  {{ request('type') ==  "active" ? 'active' : '' }} ">
                                    {{ __('Active') }} ({{$active}})
                                </a>
                                <a href="{{ route('admin.plans.index', ['type' => 'inactive']) }}"
                                   class="mr-2 btn btn-outline-primary  {{ request('type') ==  "inactive" ? 'active' : '' }} ">
                                    {{ __('Inactive') }} ({{$inactive}})
                                </a>
                            </div>
                            <div class="clearfix mb-3"></div>
                            @if(count($plans) > 0)
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
                                            <th>{{ __('SL') }}</th>
                                            <th>{{ __('Plan Name') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Duration') }}</th>
                                            <th>{{ __('Total Order') }}</th>
                                            <th>{{ __('Total Earn') }}</th>
                                            <th>{{ __('Active Orders') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Is Trial') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($plans as $key =>  $plan)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" name="id[]" id="plan-{{ $plan->id }}"
                                                               class="custom-control-input checked_input"
                                                               value="{{ $plan->id }}" data-checkboxes="mygroup">
                                                        <label for="plan-{{ $plan->id }}" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{  $key+1 }}</td>
                                                <td>{{ $plan->name }}</td>
                                                <td>{{ number_format($plan->price == '-1' ? 0 : $plan->price, 2) }}</td>
                                                <td>{{ $plan->duration == '-1' ? 'Unlimited' : $plan->duration .' '. __('Days')  }}</td>
                                                <td> {{ $plan->orders_count }} </td>
                                                <td> {{ number_format($plan->orders_sum_price, 2) }} </td>
                                                <td> {{ $plan->active_orders_count }}</td>
                                                <td>@if($plan->status ==1)
                                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>@if($plan->is_trial ==1)
                                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('Action') }}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item has-icon"
                                                           href="{{ route('admin.plans.edit',$plan->id) }}">
                                                            <i class="fa fa-edit"></i>
                                                            {{ __('Edit') }}
                                                        </a>

                                                        @if($plan->price != '-1' && $plan->is_trial == 0 && $plan->active_orders_count == 0)
                                                            <a class="dropdown-item has-icon delete-confirm"
                                                               href="javascript:void(0)"
                                                               data-action={{ route('admin.plans.destroy', $plan->id) }}>
                                                                <i class="fa fa-trash"></i>
                                                                {{ __('Delete') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <x-datanotfound :message="__('No plans available yet')">
                                </x-datanotfound>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
