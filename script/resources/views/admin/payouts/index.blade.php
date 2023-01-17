@extends('layouts.backend.app')

@section('title', __('All Payouts'))

@section('content')

    <div class="section-body">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('*/payouts') && !request('status') ? 'active' : '' }}" href="{{ route('admin.payouts.index') }}">@lang('All')
                                <span class="badge badge-primary">{{ $total_payouts }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}" href="{{ route('admin.payouts.index', ['status' => 'approved']) }}">{{ __('Approved') }}
                                <span class="badge badge-primary">{{ $total_approved }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.payouts.index', ['status' => 'pending']) }}">{{ __('Pending') }}
                                <span class="badge badge-primary">{{ $total_pending }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('admin.payouts.index', ['status' => 'rejected']) }}"> {{ __('Rejected') }} <span class="badge badge-primary">{{ $total_rejected }}</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.payouts.delete') }}" class="ajaxform_with_mass_delete">
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
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center table-borderless">
                                    <thead>
                                        <tr>
                                            <th class="text-center pt-2">
                                                <div class="custom-checkbox custom-checkbox-table custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>#</th>
                                            <th>{{ __('Method') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Charge') }}</th>
                                            <th>{{ __('Currency') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payouts as $payout)
                                            <tr id="row4">
                                                <td class="text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup" name="ids[]" class="custom-control-input checked_input" value="{{ $payout->id }}" id="data-{{ $payout->id }}">
                                                        <label for="data-{{ $payout->id }}" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ optional($payout->method)->name }}</td>
                                                <td>{{ date('d M y', strtotime($payout->created_at)) }}</td>
                                                <td>{{ $payout->amount }}</td>
                                                <td>{{ $payout->charge }}</td>
                                                <td>{{ $payout->method->currency->name ??   '' }}</td>
                                                <td>
                                                    @if ($payout->status == 'pending')
                                                        <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                    @elseif ($payout->status == 'rejected')
                                                        <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                                    @elseif ($payout->status == 'approved')
                                                        <span class="badge badge-success">{{ __('Approved') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        {{ __('Action') }}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('admin.payouts.show', $payout->id) }}">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                            {{ __('View') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-right">
                        {{ $payouts->links('admin.components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
