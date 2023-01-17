@extends('layouts.backend.app')

@section('title', __('Subscribers'))

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="float-left">
                            <h6 class="text-primary">{{ __('Subscriber Manager') }}</h6>
                        </div>
                        <div class="float-right">
                            <form method="get">
                                <div class="input-group">
                                    <input name="src" type="text" value="{{ request('src') ?? '' }}"
                                           class="form-control" placeholder="{{ __('Search by email') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix mb-3"></div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Subscribe At') }}</th>
                                    <th class="text-right">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subscribers['members'] as $subscriber)
                                    <tr>
                                        <td>{{ $subscriber['email_address'] ?? null }}</td>
                                        <td>
                                            @if($subscriber['status'] == 'subscribed')
                                                <span class="badge badge-success">{{ __('Subscribed') }}</span>
                                            @elseif($subscriber['status'] == 'unsubscribed')
                                                <span class="badge badge-danger">{{ __('Unsubscribed') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('Deleted') }}</span>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            {{ formatted_date($subscriber['timestamp_opt'], 'd M, Y - h:i A') }}
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item has-icon unsubscribe-confirm" href="javascript:void(0)" data-action="{{ route('admin.subscribers.unsubscribe', $subscriber['email_address']) }}">
                                                    <i  class="fa fa-stop-circle"></i>
                                                    {{ __('Unsubscribe') }}
                                                </a>
                                                <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.subscribers.destroy', $subscriber['email_address']) }}">
                                                    <i  class="fa fa-user-times"></i>
                                                    {{ __('Delete') }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
