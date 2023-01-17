@extends('layouts.backend.app')

@section('title', __('Enroll Log'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Enroll Log') }}</h4>

            <form class="card-header-form d-flex gap-3">
                <div class="input-group">
                    <input type="text" name="src" value="{{ request('src') }}" class="form-control" placeholder="{{ __('Search') }}"/>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if($subscriptions->count() > 0 || request('src') !== null)
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap card-table text-center">
                        <thead>
                        <tr>
                            <th>{{ __('Invoice') }}</th>
                            <th>{{ __('Plan') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Expire At') }}</th>
                        </tr>
                        </thead>
                        <tbody class="list font-size-base rowlink" data-link="row">
                        @foreach($subscriptions as $key => $subscription)
                            <tr>
                                <td>{{ $subscription->invoice_no }}</td>
                                <td>{{ $subscription->plan->name }}</td>
                                <td>{{ currency_format($subscription->amount) }}</td>
                                <td>{{ formatted_date($subscription->will_expire) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found></x-data-not-found>
            @endif
        </div>
        <div class="card-footer">
            {{ $subscriptions->appends(['src' => request('src')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
