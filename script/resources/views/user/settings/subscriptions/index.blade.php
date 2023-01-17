@extends('layouts.user.app')

@section('title', __('Subscriptions'))

@section('content')
    <div class="row">
        @foreach($subscriptions as $subscription)
            <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing">
                    <div class="pricing-title">
                        {{ $subscription->name }}
                    </div>
                    <div class="pricing-padding">
                        <div class="pricing-price">
                            <div>
                                @if($subscription->price < 0)
                                    {{ __('FREE') }}
                                @else
                                    {{ currency_format($subscription->price) }}
                                @endif
                            </div>
                            @if($subscription->duration < 0)
                                <div>{{ __('Lifetime') }}</div>
                            @else
                                @if(in_array($subscription->duration, [30, 31]))
                                    {{ __('Monthly') }}
                                @elseif(in_array($subscription->duration, [360, 365]))
                                    {{ __('Yearly') }}
                                @elseif($subscription->duration < 0)
                                    {{ __('Unlimited') }}
                                @else
                                    {{$subscription->duration}}
                                    {{ __('Days') }}
                                @endif
                            @endif
                        </div>
                        <div class="pricing-details">
                            @foreach($subscription->meta as $key => $value)
                                <div class="pricing-item">
                                    <div @class(['pricing-item-icon', 'bg-danger text-white' => !$value])>
                                        <i @class(['fas', ' fa-check' => $value, 'fa-times' => !$value])></i>
                                    </div>

                                    <div class="pricing-item-label">
                                        @if($key == 'max_file_size')
                                            {{ human_filesize($value * 1048576) }}
                                        @elseif($key == 'product_limit' || $key == 'subscription_plan_limit')
                                            {{ $value != -1 ? $value > 1 ? $value : '' : 'Unlimited' }}
                                        @elseif($key == 'withdraw_charge')
                                            {{ __(":percentage%", ['percentage' => $value]) }}
                                        @endif
                                        {{ ucfirst(str($key)->replace('_', ' ')->explode(' ')->implode(' ')) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="pricing-cta">
                        @if($subscription->id == Auth::user()->plan_id)
                            <a href="javascript:void(0)" class="bg-primary text-white subscribed cursor-unset" disabled>
                                {{ __('Subscribed') }}
                                <i class="fas fa-check"></i>
                            </a>

                            <a
                                href="javascript:void(0)"
                                class="confirm-action renew cursor-pointer"
                                data-action="{{ route('user.settings.subscriptions.store', ['plan' => $subscription->id]) }}"
                                data-method="POST"
                                {{ __('Renew') }}
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            @if ($subscription->price == -1 && Auth::user()->is_free_enrolled)
                                <a
                                    href="javascript:void(0)"
                                    class="disabled"
                                    disabled
                                >
                                    {{ __('Subscribe') }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            @else
                                <a
                                    href="javascript:void(0)"
                                    class="confirm-action"
                                    data-action="{{ route('user.settings.subscriptions.store', ['plan' => $subscription->id]) }}"
                                    data-method="POST"
                                >
                                    {{ __('Subscribe') }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif

                        @endif

                        @if (!Auth::user()->is_trial_enrolled && $subscription->is_trial && $subscription->id !== Auth::user()->plan_id)
                        <a
                            href="javascript:void(0)"
                            class="confirm-action bg-danger text-white"
                            data-action="{{ route('user.settings.subscriptions.store', ['plan' => $subscription->id, 'trial' => true]) }}"
                            data-method="POST"
                        >
                            {{ __('Try Trial') }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        $(function() {
            $('.subscribed').hover(function() {
                $(this)
                    .hide()
                    .next('.renew')
                    .show();
            });

            $('.renew').mouseout(function() {
                $(this)
                    .hide()
                    .prev('.subscribed')
                    .show();
            });
        });
    </script>
@endpush
