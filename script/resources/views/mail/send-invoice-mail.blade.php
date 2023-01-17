@component('mail::message')
# Hi {{ $options['order']->name }}
Thanks for checking out <b>{{ $options['product_name'] ?? null }}</b>

@component('mail::table')
|Invoice|Product|Amount|Order At|
|-------|----|:----:|:-------:|
|{{ $options['order']->invoice_no }}|{{ $options['order']->product->name }}|{{ currency_format($options['price'] ?? 0) }}|{{ formatted_date($options['order']->created_at) }} |
@endcomponent

@component('mail::button', ['url' => $options['download_link'] ?? null])
Download
@endcomponent

The download link is now available for 7 days.

Thanks again,<br>
{{ config('app.name') }}
@endcomponent
