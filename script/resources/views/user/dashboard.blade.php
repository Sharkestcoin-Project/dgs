@extends('layouts.user.app')

@section('title', __('Dashboard'))

@section('content')

    @foreach ($warnings as $warning)
        <div class="alert alert-{{ $warning['type'] }}">
            {{ $warning['message'] }}
            @if (isset($warning['button_name']) && isset($warning['button_url']))
                <a class="btn btn-dark" href="{{ $warning['button_url'] }}">{{ $warning['button_name'] }}</a>
            @endif
        </div>
    @endforeach
    <div class="row">
        <div class="col-md-8">
            <div class="row statistic-card">
                <div class="col-lg-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Total Revenue') }}</h4>
                            </div>
                            <div class="card-body">
                        <span id="revenue">
                            <img src="{{ asset('admin/img/img/loader.gif') }}" alt="">
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Total Sales') }}</h4>
                            </div>
                            <div class="card-body">
                        <span id="totalSales">
                            <img src="{{ asset('admin/img/img/loader.gif') }}" alt="">
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Average Sales') }}</h4>
                            </div>
                            <div class="card-body">
                        <span id="averageSales">
                            <img src="{{ asset('admin/img/img/loader.gif') }}" alt="">
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Average Monthly') }}</h4>
                            </div>
                            <div class="card-body">
                        <span id="averageMonthlySales">
                            <img src="{{ asset('admin/img/img/loader.gif') }}" alt="">
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @if(isset($user->plan))
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>{{ __("Plan") }}</strong>
                                <span>{{ $user->plan->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>{{ __("Product Limit") }}</strong>
                                <div class="d-flex flex-column">
                                    <span>{{ __("Limit :count", ['count' => $user->product_limit]) }}</span>
                                    <span>{{ __("Left :count", ['count' => max($user->product_limit - $user->products_count, 0)]) }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>{{ __("Subscription Plan Limit") }}</strong>
                                <div class="d-flex flex-column">
                                    <span>{{ __("Limit :count", ['count' => $user->subscription_plan_limit]) }}</span>
                                    <span>{{ __("Left :count", ['count' => max($user->subscription_plan_limit - $user->subscriptions_count, 0)]) }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>{{ __("Expire at") }}</strong>
                                <span>{{ formatted_date(Auth::user()->will_expire) }}</span>
                            </li>
                        </ul>
                    @else
                        <a href="{{ route('user.settings.subscriptions.index') }}" class="btn btn-primary">
                            {{ __("Subscribe Now") }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>
                {{ __('Revenue') }}
                <img src="{{ asset('uploads/loader.gif') }}" height="20" id="revenueByMonthLoader">
            </h4>
        </div>
        <div class="card-body">
            <canvas id="myChart" height="158"></canvas>
        </div>
    </div>

    <input type="hidden" id="defaultCurrencySymbol" value="{{ default_currency('symbol') }}">
    <input type="hidden" id="defaultCurrencyPosition" value="{{ default_currency('position') }}">
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/chatjs/Chart.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/chatjs/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/custom/user/dashboard.js') }}"></script>
@endpush
