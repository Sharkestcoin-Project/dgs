@extends('layouts.backend.app')

@section('title', __('Cron Jobs'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-circle"></i> {{ __('Membership check expiration & Delete Temporary Files') }} <code>{{ __('Once/day') }}</code>
                </h6>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="schedule-cron" value=" * * * * * curl {{ route('cron.run') }} >> /dev/null 2>&1" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary clipboard-button" type="button" data-clipboard-target="#schedule-cron">
                            <i class="fas fa-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6>
                    <i class="fas fa-facebook-messenger"></i>
                    {{ __('Real Time Chat Websocket') }}
                </h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="" class="text-danger font-weight-bolder">
                        <strong>{{ __('Note:') }} :</strong> {{ __('You Need Add This Command In Your Supervisor To Real Time Chat') }}
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="websocket-supervisor" value="php {{ base_path() }}/artisan websockets:serve >> /dev/null 2>&1" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary clipboard-button" type="button" data-clipboard-target="#websocket-supervisor">
                                <i class="fas fa-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-circle"></i> {{ __('Send Mail with Queue') }}</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="" class="text-danger font-weight-bolder">
                        <strong>{{ __('Note:') }} :</strong> {{ __('You Need Add This Command In Your Supervisor And Also Make QUEUE_MAIL On From System Settings To Mail Configuration.') }}
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="queue-supervisor" value="php {{ base_path() }}/artisan queue:work >> /dev/null 2>&1" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary clipboard-button" type="button" data-clipboard-target="#queue-supervisor">
                                <i class="fas fa-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Customize Cron Jobs') }}</h4>
            </div>
            <form class="ajaxform_with_reload" method="post" action="{{ route('admin.cron.store') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('Make First Alert To Customer The Subscription Will Ending Soon') }}</label><br />
                                <span>
                                    {{ __('Note:') }} <span
                                        class="text-danger"><small>{{ __('It Will Send Notification Everyday Within The Selected Days') }}</small></span>
                                </span>
                                <input type="number" required  class="form-control" name="first_expire_days" value="{{ $cron->first_expire_days ?? ''}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('Make Second Alert To Customer The Subscription Will Ending Soon') }}</label><br />
                                <span>
                                    {{ __('Note:') }} <span
                                        class="text-danger"><small>{{ __('It Will Send Notification Everyday Within The Selected Days') }}</small></span>
                                </span>
                                <input type="number" required  class="form-control" name="second_expire_days" value="{{ $cron->second_expire_days ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('First Alert Message Before Expire Subscription') }}</label>

                                <textarea  required class="form-control" name="first_alert_message">{{ $cron->first_alert_message ?? '' }}</textarea>
                                <small>{{ __('Html supported') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('Second Alert Message Before Expire Subscription') }}</label>
                                <textarea required class="form-control" name="second_alert_message">{{ $cron->second_alert_message ?? '' }}</textarea>
                                <small>{{ __('Html supported') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('After Subscription Expire Message') }}</label>
                                <textarea  required class="form-control" name="expire_message">{{ $cron->expire_message ?? '' }}</textarea>
                                 <small>{{ __('Html supported') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('Trial Expire Message') }}</label>

                                <textarea required class="form-control" name="trial_expired_message">{{ $cron->trial_expired_message ?? '' }}</textarea>
                                 <small>{{ __('Html supported') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Changes') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script src="{{ asset('admin/plugins/clipboard-js/clipboard.min.js') }}"></script>
    <script>
        "use strict";
        var clipboard = new ClipboardJS('.clipboard-button');

        clipboard.on('success', function(e) {
            Sweet('success', 'Copied to clipboard')
            e.clearSelection();
        });
    </script>
@endpush
