@extends('layouts.backend.app', [
    'button_name' => __('Add New'),
    'button_link' => route('admin.currencies.create'),
])

@section('title', __('Currencies'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Currency List') }}</h4>
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
                            <th>{{ __('Position') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Default') }}</th>
                            <th class="text-right">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currencies ?? [] as $currency)
                            <tr>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->code }}</td>
                                <td>{{ $currency->rate }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td>{{ $currency->position }}</td>
                                <td>
                                    @if ($currency->status)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($currency->is_default)
                                        <span class="badge badge-success">{{ __('Yes') }}</span>
                                    @else
                                        <span class="badge badge-dark">{{ __('No') }}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        @if (!$currency->is_default)
                                            <a 
                                            class="btn btn-success confirm-action" 
                                            href="javascript:void(0)" 
                                            data-action="{{ route('admin.currencies.make.default', $currency->id) }}" 
                                            data-method="PUT"
                                            data-alert-message="{{ __('The :name currency make as default?', ['name' => $currency->name]) }}"
                                            data-toggle="tooltip" 
                                            title="" 
                                            data-original-title="Make Default!"
                                            >
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @endif
                                        <a class="btn btn-warning" href="{{ route('admin.currencies.edit', $currency->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a class="btn btn-danger delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.currencies.destroy', $currency->id) }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection