@component('mail::message')
@if($type == 'customer')
Hi <strong>{{ $data['name'] }}</strong>,

You are subscribed to <strong>{{ $data['plan']->name }}</strong> plan.
@else

<strong>{{ $data['name'] }}</strong> subscribed to you <strong>{{ $data['plan']->name }}</strong> plan.
@endif

@component('mail::table')
    |Invoice|Plan|Amount|Expire At|
    |-------|----|:----:|:-------:|
    |{{ $order->invoice_no }}|{{ $order->plan->name }}|{{ currency_format($order->plan->price, 'icon', $order->plan->currency->symbol) }}<sub>/{{ str($order->plan->period)->replace('nthly', '')->replace('early', '') }}</sub>|{{ formatted_date($order->subscription_expire_at) }} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
