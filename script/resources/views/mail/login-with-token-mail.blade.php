@component('mail::message')

{!! $mailable['message'] !!}

@component('mail::button', ['url' => $mailable['url'] ?? '/'])
{{ $mailable['button_text'] ?? __('Login') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
