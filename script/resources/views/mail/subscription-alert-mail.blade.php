@component('mail::message')
Hi {{ $user->name }},

Your membership at {{ config('app.name') }} is about to expire on {{ $user->will_expire }}.

Good news! There’s still time to renew, and it’s as easy as ever – just click the link below, pick the subscription that suits your needs and follow the prompts.

@component('mail::table')
|Plan Name|Price|Period|
|:--------|----:|:----:|
|{{ $user->plan->name }}|{{ currency_format($user->plan->price) }}|{{ __("abcd") }}|
@endcomponent

@component('mail::button', ['url' => route('user.settings.subscriptions.plan-renew', ['plan' => $user->plan_id]) ])
RENEW NOW
@endcomponent

If you have any questions regarding your membership, benefits, or renewal, please don’t hesitate to reach out by replying to this email or <a href="{{ url('/contact') }}">contact</a> with us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
