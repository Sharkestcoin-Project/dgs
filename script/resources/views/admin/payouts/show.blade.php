@extends('layouts.backend.app', [
    'prev' => route('admin.payouts.index')
])

@section('title', __('Payout details'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>@lang('Payout method info')</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Limit') }}</th>
                                <th>{{ __('Currency') }}</th>
                                <th>{{ __('Charge') }}</th>
                                <th>{{ __('Charge Type') }}</th>
                                <th>{{ __('Delay') }}</th>
                                <th>{{ __('Created At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $payout->method->name }}</td>
                                <td>{{ $payout->method->min_limit .' - ' . $payout->method->max_limit }}</td>
                                <td>{{ $payout->method->currency->name }}</td>
                                <td>{{ $payout->method->percent_charge > 0 ? $payout->method->percent_charge : $payout->method->fixed_charge }}</td>
                                <td>
                                    <div class="badge badge-{{ $payout->method->percent_charge > 0 ? 'primary' : 'warning' }}">
                                        {{ $payout->method->percent_charge > 0 ? __('Percantage') : __('Fixed') }}
                                    </div>
                                </td>
                                <td>{{ $payout->method->delay }}</td>
                                <td>{{ date('d M y', strtotime($payout->method->created_at)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-body">
                <h4>@lang('Payout info')</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Charge') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </thead>
                        <tbody>
                            <td>{{ $payout->user->name ?? '' }}</td>
                            <td>{{ $payout->user->email ?? '' }}</td>
                            <td>{{ currency_format($payout->amount, currency:$payout->method->currency) }}</td>
                            <td>{{ currency_format($payout->charge, currency:$payout->method->currency) }}</td>
                            <td>
                                @if ($payout->status == 'pending')
                                    <span class="badge badge-warning">{{ __('Pending') }}</span>
                                @elseif ($payout->status == 'rejected')
                                    <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                @elseif ($payout->status == 'approved')
                                    <span class="badge badge-success">{{ __('Approved') }}</span>
                                @endif
                            </td>
                            <td>{{ formatted_date($payout->created_at) }}</td>
                            <td>
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                    id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ __('Action') }}
                                </button>
                                <div class="dropdown-menu">
                                    @if ($payout->status != 'approved')
                                    <a class="dropdown-item action-confirm" href="javascript:void(0)" data-action="{{ route('admin.payouts.approved', ['payout' => $payout->id]) }}" data-text="You want to approve this payout?" data-icon="success">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        {{ __('Approve') }}
                                    </a>
                                    @endif
                                    @if ($payout->status != 'rejected')
                                    <a class="dropdown-item action-confirm" href="javascript:void(0)" data-action="{{ route('admin.payouts.reject', ['payout' => $payout->id]) }}" data-text="You want to reject this payout?" data-icon="warning">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                        {{ __('Reject') }}
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-body">
                <h4>@lang('Account infos')</h4>
                <div class="table-responsive">
                    @php
                        $fields = json_decode($payout->method->data);
                        $datas = json_decode($usermethod->payout_infos ?? 0);
                    @endphp
                    <table class="table table-striped">
                        @if ($datas || $fields)
                        @foreach ($fields as $key => $field)
                            <tr>
                                <th>{{ $field->label }}</th>
                                <td class="text-end">{{ $datas[$key]->data ?? '' }}</td>
                            </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
