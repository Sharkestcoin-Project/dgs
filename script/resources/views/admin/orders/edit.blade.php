@extends('layouts.backend.app', [
    'prev'=> route('admin.orders.index')
])

@section('title','Orders')

@section('content')
    <section class="section">
        <div class="row mb-none-30">
            <div class="col-lg-8 offset-lg-2 mb-30">
                <div class="card b-radius-10 overflow-hidden box-shadow1">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted">{{ __('Orders Via') }} {{$order->gateway->name}}</h5>
                        <div class="p-3 bg-white">
                            <img src="{{asset($order->gateway->logo)}}" alt="{{$order->gateway->name}}" class="img-fluid circle">
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Date') }} <span class="font-weight-bold">{{ date('d M y', strtotime($order->created_at)) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Transaction Number') }}  <span class="font-weight-bold">{{$order->trx}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Username') }}
                                <span class="font-weight-bold">
                                      <a href="{{route('admin.users.show',$order->user->id)}}"><span>@</span>{{$order->user->name}}</a>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Method') }}  <span class="font-weight-bold">{{$order->gateway->name}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Amount') }}   <span class="font-weight-bold">{{ number_format($order->plan->price,2) }} {{ strtoupper($currency_name) }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Charge') }}   <span class="font-weight-bold">{{ number_format($order->gateway->charge,2) }} {{ strtoupper($currency_name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('After Charge') }}   <span class="font-weight-bold">{{ number_format($order->gateway->charge + $order->plan->price,2) }} {{ strtoupper($currency_name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Rate') }}
                                <span class="font-weight-bold">{{ number_format($order->gateway->rate,2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Payable') }}  <span class="font-weight-bold">    {{ number_format((($order->plan->price + ($order->plan->price / 100) * $tax) * $order->gateway->rate)  + $order->gateway->charge,2) }} {{ strtoupper($currency_name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Status') }}
                                @if($order->status == 1)
                                <span class="badge badge-pill badge-success">{{ __('Active') }}</span>
                                    @elseif($order->status == 0)
                                        <span class="badge badge-pill badge-danger">{{ __('Failed') }}</span>
                                @elseif($order->status == 2)
                                    <span class="badge badge-pill badge-info">{{ __('Pending') }}</span>
                                @elseif($order->status == 3)
                                    <span class="badge badge-pill badge-warning">{{ __('Expired') }}</span>
                                @endif
                            </li>
                            @if($order->ordermeta)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Attachment') }} <span class="font-weight-bold">
                                   <a target="_blank" href="{{asset(json_decode(optional($order->ordermeta)->value)->attachment ?? null)}}">{{ __('View Attachment') }}</a>
                               </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Comment') }} <span class="font-weight-bold"> {{json_decode(optional($order->ordermeta)->value)->comment ?? null}} </span>
                            </li>
                        @endif
                            <form method="post" class="ajaxform"
                                  action="{{route('admin.orders.payment-status',$order->id)}}">
                                @csrf
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Payment Status') }} <span class="font-weight-bold">
                                    <select class="form-control" name="payment_status">
                                       <option value="1" {{$order->payment_status == 1 ? 'selected' : ''}}>{{ __('Active') }}</option>
                                       <option value="0" {{$order->payment_status == 0 ? 'selected' : ''}}>{{ __('Failed') }}</option>
                                       <option value="2" {{$order->payment_status == 2 ? 'selected' : ''}}>{{ __('Pending') }}</option>
                                    </select>
                                    </span>
                                </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary col-12 basicbtn" type="submit">{{ __('Update') }}</button>

                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
