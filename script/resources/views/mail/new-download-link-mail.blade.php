@component('mail::message')

<b>{{ $order->product->name }}</b> {{ __('download link') }}

@component('mail::button', ['url' => route('download.product', $order->token)])
{{ __('Download') }}
@endcomponent

{{ __('The download link is now available for 7 days.') }}

{{ __('Thanks again') }},<br>
{{ config('app.name') }}
@endcomponent
