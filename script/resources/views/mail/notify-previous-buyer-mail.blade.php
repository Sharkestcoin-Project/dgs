@component('mail::message')

<strong>{{ $product->name }}</strong> has been updated.

@component('mail::table')
    | Product             | Price         | Updated At  |
    | ------------------- |:-------------:| -----------:|
    | {{ $product->name }}| {{ currency_format($product->price, 'icon', $product->currency->symbol) }}| {{ formatted_date($product->updated_at) }} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
