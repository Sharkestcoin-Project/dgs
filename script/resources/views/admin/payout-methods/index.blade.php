@extends('layouts.backend.app', ['title' => __('Payout method')])

@section('title', __('Payout Methods'))

@section('content')
    <div class="section-body">
        <div class="method">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.payout-methods.delete') }}" class="ajaxform_with_mass_delete">
                            @csrf

                            <div class="float-left mb-3">
                                <div class="input-group">
                                    <select class="form-control action" name="method">
                                        <option value="">{{ __('Select Action') }}</option>
                                        <option value="delete">{{ __('Delete Permanently') }}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('admin.payout-methods.create') }}">{{ __('Create new') }}</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center pt-2">
                                                <div class="custom-checkbox custom-checkbox-table custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Currency') }}</th>
                                            <th>{{ __('Rate') }}</th>
                                            <th>{{ __('Limit') }}</th>
                                            <th>{{ __('Charge') }}</th>
                                            <th>{{ __('Delay') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($methods as $method)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup" name="ids[]" class="custom-control-input checked_input" value="{{ $method->id }}" id="data-{{ $method->id }}">
                                                        <label for="data-{{ $method->id }}" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $method->name }}</td>
                                                <td>{{ $method->currency->name ?? '' }}</td>
                                                <td>{{ $method->currency->rate ?? '' }}</td>
                                                <td>{{ $method->min_limit .' - ' . $method->max_limit }}</td>
                                                <td>{{ $method->percent_charge > 0 ? $method->percent_charge : $method->fixed_charge }}</td>
                                                <td>{{ $method->delay }}</td>
                                                <td>{{ date('d M y', strtotime($method->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ route('admin.payout-methods.edit', $method->id) }}" class="btn text-primary btn-sm text-center"><i class="far fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-right">
                        {{ $methods->links('admin.components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
