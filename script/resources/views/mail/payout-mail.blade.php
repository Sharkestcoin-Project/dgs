@component('mail::message')
<h1 style="text-align: center; color: #6777ef;">@lang('Payout request from') {{ env('APP_NAME') }}</h1>

<table style="width: 100%; border: 1px solid #000">
    <thead style="background: rgb(248,249,250); padding: 10px 0;">
        <tr>
            <th>{{ __('User name') }}</th>
            <td>{{ $payout->user->name ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ __('User email') }}</th>
            <td>{{ $payout->user->email ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ __('Amount') }}</th>
            <td>{{ $payout->amount }}</td>
        </tr>
        <tr>
            <th>{{ __('Payout method') }}</th>
            <td>{{ $payout->method->name ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ __('Status') }}</th>
            <td style="text-transform: uppercase; color: {{ $payout->status == 'rejected' ? 'red':'green' }}">{{ $payout->status }}</td>
        </tr>
        <tr>
            <th>{{ __('Charge') }}</th>
            <td>{{ $payout->charge }}</td>
        </tr>
    </tbody>
</table>
@endcomponent
