@extends('layouts.backend.app', [
     'prev'=> route('admin.orders.index')
])

@section('title', 'Order')

@section('content')
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>{{ __('Invoice') }}</h2>
                        <div class="invoice-number">{{ __('Order # :number',  ['number' => $order->invoice_no]) }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>{{ __('Billed To:') }}</strong><br>
                                {{ $order->user->name }}<br>
                                {{ $order->user->phone }}<br>
                                {{ $order->user->email }}<br>
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>{{ __('Billed From:') }}</strong><br>
                                {{ config('app.name') }}<br>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>{{ __('Payment Method:') }}</strong><br>
                                {{ $order->gateway->name }}<br>
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>{{ __('Order Date:') }}</strong><br>
                                {{ formatted_date($order->created_at) }}<br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="section-title">{{ __('Order Summary') }}</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <tr>
                                <th>{{ __('Plan') }}</th>
                                <th class="text-right">{{ __('Price') }}</th>
                                <th class="text-right">{{ __('Tax') }}</th>
                                <th class="text-center">{{ __('Payment Status') }}</th>
                                <th class="text-center">{{ __('Status') }}</th>
                            </tr>
                            <tr>
                                <td>{{ $order->plan->name }}</td>
                                <td class="text-right">{{ number_format($order->price, 2) }}</td>
                                <td class="text-right">{{ number_format($order->tax, 2) }}</td>
                                <td class="text-center">
                                    @php
                                        $payment_status = [
                                        0 => ['text' => __('Rejected')],
                                        1 => ['text' => __('Accepted')],
                                        2 => ['text' => __('Pending')],
                                        3 => ['text' => __('Expired')],
                                        4 => ['text' => __('Trash')],
                                    ][$order->payment_status];
                                    @endphp
                                    {{ $payment_status['text'] }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $status = [
                                          0 => ['text' => __('Rejected')],
                                          1 => ['text' => __('Accepted')],
                                          2 => ['text' => __('Pending')],
                                          3 => ['text' => __('Expired')]
                                         ][$order->status]
                                    @endphp
                                    {{ $status['text'] }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 text-right">
                            <hr class="mt-2 mb-2">
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">{{ __('Total') }}</div>
                                <div class="invoice-detail-value invoice-detail-value-lg">{{ number_format($order->price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-md-right">
            <div class="btn-group">

                <a href="{{ route('admin.orders.print.invoice', $order->id) }}" class="btn btn-danger btn-icon icon-left">
                    <i class="fas fa-file-pdf"></i>
                    {{ __('PDF') }}
                </a>
                <a href="{{ route('admin.orders.print.invoice', ['order' => $order->id, 'type' => 'print']) }}" class="btn btn-warning btn-icon icon-left">
                    <i class="fas fa-print"></i>
                    {{ __('Print') }}
                </a>
            </div>
        </div>
    </div>
@endsection

