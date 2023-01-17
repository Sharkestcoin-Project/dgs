@component('mail::message')
Hi {{ $order->subscriber->name }}

Your subscription will expire at {{ formatted_date($order->subscription_expire_at) }}

@component('mail::table')
    |Invoice|Plan|Amount|Expire At|
    |-------|----|:----:|:-------:|
    |{{ $order->invoice_no }}|{{ $order->plan->name }}|{{ currency_format($order->plan->price, 'icon', $order->plan->currency->symbol) }}<sub>/{{ str($order->plan->period)->replace('nthly', '')->replace('early', '') }}</sub>|{{ formatted_date($order->subscription_expire_at) }} |
@endcomponent

@component('mail::button', ['url' => route('subscriptions.renew', [$order->user->username, $order->id])])
Renew Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
