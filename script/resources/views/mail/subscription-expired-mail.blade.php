@component('mail::message')
Hi {{ $user->name }},

Thanks for using our {{ $user->plan->name }} subscription. We’re really sad to see you go – but we had a good run.

If you have any outstanding questions, feel free to <a href="{{ url('/contact') }}">contact</a> us.

All the best,

@component('mail::button', ['url' => route('user.settings.subscriptions.index')])
    Purchase a new plan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
