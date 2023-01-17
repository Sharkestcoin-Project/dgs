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
        <td align="right">
            <h3>{{ __('Order # :number',  ['number' => $order->invoice_no]) }}</h3>
        </td>
    </tr>
</table>

<br><br>

<table width="100%">
    <tr>
        <td valign="top">
            <address>
                <strong>{{ __('Billed From:') }}</strong><br>
                {{ $order->name ?? null}}<br>
                {{ $order->email ?? null }}<br>
            </address>
        </td>
        <td align="right">
            <address>
                <strong>{{ __('Billed To:') }}</strong><br>
                {{ $order->user->name ?? null}}<br>
                {{ $order->user->email ?? null }}<br>
            </address>
        </td>
    </tr>
</table>

<br>

<table width="100%">
    <tr>
        <td valign="top">
            <address>
                <strong>{{ __('Payment Method:') }}</strong><br>
                {{ $order->gateway->name }}<br>
            </address>
        </td>
        <td align="right">
            <address>
                <strong>{{ __('Order Date:') }}</strong><br>
                {{ formatted_date($order->created_at) }}<br>
            </address>
        </td>
    </tr>
</table>

<br/>

<h3>{{ __('Order Summary') }}</h3>
<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>{{ __('Product Name') }}</th>
        <th>{{ __('Price') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ \Illuminate\Support\Str::limit($order->product->name,30) }}</td>
        <td>{{ number_format($order->amount, 2) }}</td>
    </tr>
    </tbody>
</table>
<br>
<table width="100%">
    <tr>
        <td align="right">
            <h2>{{ __('Total') }} {{ number_format($order->amount, 2) }}</h2>
        </td>
    </tr>
</table>
<hr>
</body>
</html>
