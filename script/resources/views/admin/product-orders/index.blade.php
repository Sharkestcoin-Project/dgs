@extends('layouts.backend.app')


@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-clipboard"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>{{ __('Total Orders') }}</h4>
                    </div>
                    <div class="card-body">
                        {{$all->count()}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>{{ __('Total Amount') }}</h4>
                    </div>
                    <div class="card-body">
                        {{$all->sum('amount')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>{{ __('Orders Log') }}</h4>

            <form class="card-header-form">
                <div class="input-group">
                    <input type="text" name="src" value="{{ request('src') }}" class="form-control" placeholder="{{ __('Search by invoice or user') }}"/>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <button class="btn btn-sm btn-primary  ml-1" type="button" data-toggle="modal" data-target="#searchmodal">
                <i class="fe fe-sliders mr-1"></i> {{ __('Filter') }} <span class="badge badge-primary ml-1 d-none">0</span>
            </button>
            <a href="{{route('admin.product-orders.pdf')}}" class="btn btn-outline-danger btn-pdf pt-2 border-0"><i class="fa fa-file-pdf"></i> {{ __('PDF') }}</a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.product-orders.mass-destroy') }}" method="POST" class="ajaxform_with_mass_delete">
                @csrf
                <div class="float-left">
                    <button class="btn btn-danger btn-lg basicbtn mass-delete-btn d-none" id="submit-button">{{ __('Delete') }}</button>
                </div>
                <div class="clearfix mb-3"></div>
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap card-table text-center">
                        <thead>
                        <tr>
                            <th class="text-center pt-2">
                                <div class="custom-checkbox custom-checkbox-table custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                </div>
                            </th>
                            <th class="text-left">{{ __('Invoice No') }}</th>
                            <th>{{ __('Trx') }}</th>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Gateway') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('User') }}</th>
                            <th class="text-right"> {{ __('Total') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody class="list font-size-base rowlink" data-link="row">
                        @foreach($orders as $key => $order)
                            <tr>
                                <td class="text-center">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" name="id[]" id="order-{{ $order->id }}" class="custom-control-input checked_input" value="{{ $order->id }}"  data-checkboxes="mygroup">
                                        <label for="order-{{ $order->id }}" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="text-left">{{ $order->invoice_no }}</td>
                                <td class="text-left">{{ $order->trx }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($order->product->name,30) }}</td>
                                <td>{{ $order->gateway->name }}</td>
                                <td>{{ formatted_date($order->created_at) }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->user->name }}</a>
                                </td>
                                <td >{{ currency_format($order->product->price) }}</td>

                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon"
                                           href="{{ route('admin.product-orders.show', $order->id) }}">
                                            <i class="fa fa-eye"></i>
                                            {{ __('View') }}
                                        </a>
                                        <a class="dropdown-item has-icon"
                                           href="{{ route('admin.product-orders.print.invoice', $order->id) }}">
                                            <i class="fa fa-print"></i>
                                            {{ __('Invoice') }}
                                        </a>

                                        <a class="dropdown-item has-icon delete-confirm"
                                           href="javascript:void(0)"
                                           data-action={{ route('admin.product-orders.destroy', $order->id) }}>
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
            </form>
        </div>
        <div class="card-footer">
            {{ $orders->appends(['payment_status' => request('payment_status'), 'src' => request('src')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="searchmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="card-header-title">{{ __('Filters') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">

                        <div class="form-group row mb-4">
                            <label class="col-sm-3">{{ __('Starting date') }}</label>
                            <div class="col-sm-9">
                                <input type="date" name="start" class="form-control" value="{{ request('start') }}" />
                            </div>
                        </div>
                        <hr />
                        <div class="form-group row mb-4">
                            <label class="col-sm-3">{{ __('Ending date') }}</label>
                            <div class="col-sm-9">
                                <input type="date" name="end" class="form-control" value="{{ request('end') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.product-orders.index') }}" class="btn btn-dark">
                            {{ __('Clear Filter') }}
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
