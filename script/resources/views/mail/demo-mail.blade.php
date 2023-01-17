@component('mail::message')

# Thanks
Thanks for checking out

@component('mail::button', ['url' => route('demo.index', now()->addDay()->timestamp)])
{{ __('Download') }}
@endcomponent

The download link is now available for 24 hours.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
