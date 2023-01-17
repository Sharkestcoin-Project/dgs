<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Order Invoice') }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        .gray {
            background-color: lightgray
        }
        hr {
            border: none;
            border-top: 1px dashed #8f8f8f;
            color: #fff;
            background-color: #fff;
            height: 1px;
            width: 100%;
        }
    </style>
</head>
<body>

<table width="100%">
    <tr>
        <td valign="top">
            @php
                $logos = get_option('logo_setting', true);
                $path = parse_url($logos->logo ?? null)['path'];
            @endphp
            @isset($logos->logo)
            <img src="{{ public_path($path) }}" alt="" width="150"/>
            @else
                <h2>{{ config('app.name') }}</h2>
            @endisset
        </td>

    </tr>
</table>

<br><br>


<h3>{{ __('Order Summary') }}</h3>
<hr>
    <table width="100%">
        <thead style="background-color: lightgrey">
        <tr>
            <th class="text-left">{{ __('Invoice No') }}</th>
            <th>{{ __('Plan') }}</th>
            <th>{{ __('Gateway') }}</th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Customer') }}</th>
            <th class="text-right"> {{ __('Total') }}</th>
            <th>{{ __('Payment') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $key => $order)
            <tr>
                <td>{{ $order->invoice_no }}</td>
                <td>{{ $order->plan->name }}</td>
                <td>{{ $order->gateway->name }}</td>
                <td>{{ formatted_date($order->created_at) }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->user->name }}</a>
                </td>
                <td >{{ number_format($order->plan->price, 2) }}</td>
                <td>
                    @if($order->payment_status ==2)
                        <span>{{ __('Pending') }}</span>
                    @elseif($order->payment_status ==1)
                        <span>{{ __('Complete') }}</span>
                    @elseif($order->payment_status == 0)
                        <span>{{ __('Cancel') }}</span>
                    @elseif($order->payment_status == 3)
                        <span>{{ __('Incomplete') }}</span>
                    @endif
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

<hr>
</body>
</html>
