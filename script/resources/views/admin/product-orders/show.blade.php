@extends('layouts.backend.app', [
     'prev'=> route('admin.product-orders.index')
])

@section('title', 'Order Log')

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
                                <strong>{{ __('Billed From:') }}</strong><br>
                                {{ $order->name ?? null}}<br>
                                {{ $order->email ?? null }}<br>
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>{{ __('Billed To:') }}</strong><br>
                                {{ $order->user->name}}<br>
                                {{ $order->user->email ?? null }}<br>
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
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Price') }}</th>
                            </tr>
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($order->product->name,30) }}</td>
                                <td>{{ number_format($order->amount, 2) }}</td>

                            </tr>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 text-right">
                            <hr class="mt-2 mb-2">
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">{{ __('Total') }}</div>
                                <div class="invoice-detail-value invoice-detail-value-lg">{{ number_format($order->amount, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-md-right">
            <div class="btn-group">

                <a href="{{ route('admin.product-orders.print.invoice', $order->id) }}" class="btn btn-danger btn-icon icon-left">
                    <i class="fas fa-file-pdf"></i>
                    {{ __('PDF') }}
                </a>
                <a href="{{ route('admin.product-orders.print.invoice', ['order' => $order->id, 'type' => 'print']) }}" class="btn btn-warning btn-icon icon-left">
                    <i class="fas fa-print"></i>
                    {{ __('Print') }}
                </a>
            </div>
        </div>
    </div>
@endsection

