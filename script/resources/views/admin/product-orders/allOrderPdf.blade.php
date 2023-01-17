<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Order Log') }}</title>

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
            <th>{{ __('Trx') }}</th>
            <th>{{ __('Product Name') }}</th>
            <th>{{ __('Gateway') }}</th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('User') }}</th>
            <th class="text-right"> {{ __('Total') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $key => $order)
            <tr>
                <td class="text-left">{{ $order->invoice_no }}</td>
                <td class="text-left">{{ $order->trx }}</td>
                <td>{{ \Illuminate\Support\Str::limit($order->product->name,30) }}</td>
                <td>{{ $order->gateway->name }}</td>
                <td>{{ formatted_date($order->created_at) }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->user->name }}</a>
                </td>
                <td >{{ currency_format($order->product->price) }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>

<hr>
</body>
</html>
