@extends('layouts.backend.app')

@section('title', __('Subscribers'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Subscribers List') }}</h4>

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
            @if($subscribers->count() > 0 || request('src') !== null)
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap card-table text-center">
                        <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Orders') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody class="list font-size-base rowlink" data-link="row">
                        @foreach($subscribers as $key => $subscriber)
                            <tr>
                                <td>{{ $subscriber->name }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->phone }}</td>
                                <td>{{ $subscriber->orders_count }}</td>
                                <td>
                                    <a href="{{ route('user.subscribers.show', $subscriber->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
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
            {{ $subscribers->appends(['src' => request('src')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
