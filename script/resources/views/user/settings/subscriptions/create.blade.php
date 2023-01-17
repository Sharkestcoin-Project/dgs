@extends('layouts.user.app')

@section('title', __('Make Payment'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Select a payment method') }}</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills" id="myTab3" role="tablist">
                        @foreach($gateways as $key => $gateway)
                            <li class="nav-item">
                                <a
                                    @class(['nav-link', 'active' => $loop->first])
                                    id="tab_{{ $key }}"
                                    data-toggle="tab"
                                    href="#tab_{{ $key }}_content"
                                    role="tab"
                                    aria-controls="{{ $key }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                >
                                    <img src="{{ $gateway->logo }}" alt="{{ str($gateway->name)->upper() }}" height="50" width="70">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent2">
                        @foreach($gateways as $key => $gateway)
                            <div
                                @class(['tab-pane fade show', 'active' => $loop->first])
                                id="tab_{{ $key }}_content"
                                role="tabpanel"
                                aria-labelledby="tab_{{ $key }}"
                            >
                                <form action="{{ route('user.settings.subscriptions.make-payment', $gateway->id) }}" method="post" class="ajaxform_with_redirects" enctype="multipart/form-data">
                                    @csrf
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <th>{{ __('Gateway Name') }}</th>
                                            <td>{{ str($gateway->name)->ucfirst() }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Gateway Currency') }}</th>
                                            <td>{{ $gateway->currency->code }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Subscription Amount') }}</th>
                                            <td>
                                                {{ currency_format($amount) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Gateway Charge') }}</th>
                                            <td>
                                                {{ currency_format(calculate_gateway_charge($gateway)) }}
                                            </td>
                                        </tr>
                                        @if($taxes->count() > 0)
                                            <tr>
                                                <th>
                                                    {{ __('Taxes') }}
                                                    <span class="font-weight-light">
                                                        ({{ $taxes->map(fn($tax) => $tax->name)->implode(' + ') }})
                                                    </span>
                                                </th>
                                                <td>
                                                    ({{ $taxes->map(fn($tax) =>  $tax->type == "percentage" ? $tax->rate .'%' : $tax->rate)->implode(' + ') }})
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th>{{ __('Total') }}</th>
                                            <td>{{ currency_format(calculate_taxes($amount) + calculate_gateway_charge($gateway)) }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ __('Gateway Rate') }}</th>
                                            <td>{{ $gateway->currency->rate  }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ __('Payable') }} ({{ $gateway->currency->code }})</th>
                                            <td>

                                                {{ currency_format(payable($amount, $gateway), 'icon', $gateway->currency->symbol) }}
                                            </td>
                                        </tr>

                                        @if ($gateway->phone_required == 1)
                                            <tr>
                                                <th>
                                                    <label for="phone" class="required">{{ __('Phone Number') }}</label>
                                                </th>
                                                <td>
                                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Enter your phone number') }}" required>
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($gateway->image_accept == 1)
                                            <tr>
                                                <th>
                                                    <label for="screenshot" class="required">
                                                        {{ __('Upload Attachment') }}
                                                    </label>
                                                </th>
                                                <td>
                                                    <input type="file" name="screenshot" accept=".jpg,.png,.jpeg" class="form-control" required/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="comment">
                                                        {{ __('Payment Instructions') }}
                                                    </label>
                                                </th>
                                                <td>
                                                    <textarea class="form-control h-100" name="comment" id="" cols="30" rows="10"></textarea>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary paymentbtn btn-lg float-right">
                                        <i class="fas fa-hand-holding-usd"></i>
                                        {{ __('Make Payment')}}
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
