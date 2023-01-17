@extends('layouts.user.app')

@section('title', __('My Profile'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ $user->avatar ? asset($user->avatar) : get_gravatar($user->email) }}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ __('Products') }}</div>
                            <div class="profile-widget-item-value">{{ $user->products()->count() }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ __('Orders') }}</div>
                            <div class="profile-widget-item-value">{{ $user->orders()->count() }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ __('Customers') }}</div>
                            <div class="profile-widget-item-value">{{ $user->customers()->count() }}</div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description d-flex justify-content-between">
                    <div class="profile-widget-name">{{ $user->name }}</div>
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">{{ __('Edit Profile') }}</a>
                </div>
                <div class="card-body text-center">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="2">{{ __('Subscription Details') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ __('Plan') }}</td>
                            <td>{{ $user->plan->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Product Limit') }}</td>
                            <td>{{ $user->plan->product_limit ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Storage Limit') }}</td>
                            <td>{{ human_filesize(($user->plan->max_file_size ?? 0) * 1048576) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Expire At') }}</td>
                            <td>{{ formatted_date($user->will_expire)  }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
