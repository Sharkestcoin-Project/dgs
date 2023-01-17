@extends('layouts.backend.app', [
    'prev' => route('admin.plans.index')
])

@section('title', __('Edit Plan'))

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <form class="ajaxform_with_redirect" method="post" action="{{ route('admin.plans.update', $plan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-sm-8 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4> {{ __('Edit Sellers Plan') }}</h4>
                                    <div class="form-group">
                                        <label for="name" class="required">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ $plan->name }}" placeholder="{{ __('Enter plan name') }}"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="required">{{ __('Price') }}</label>
                                        <input type="number" name="price" id="price" class="form-control"
                                               value="{{ $plan->price }}" placeholder="{{ __('Enter plan price') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="duration">{{ __('Duration') }}</label>
                                        <input type="number" name="duration" id="duration" class="form-control"
                                               value="{{ $plan->duration }}" placeholder="{{ __('Enter days') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="status" class="required">{{ __('Status') }}</label>
                                        <select name="status" id="status" class="form-control" data-control="select2"  required>
                                            <option value="1" @selected($plan->status)>{{ __('Active') }}</option>
                                            <option value="0" @selected(!$plan->status)>{{ __('Inactive') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="is_trial" class="required">{{ __('Is Trial') }}</label>
                                        <select name="is_trial" id="is_trial" class="form-control" data-control="select2"  required>
                                            <option value="0" @selected(!$plan->is_trial)>{{ __('No') }}</option>
                                            <option value="1" @selected($plan->is_trial)>{{ __('Yes') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="featured" class="required">{{ __('Is Featured') }}</label>
                                        <select name="featured" id="featured" class="form-control" data-control="select2"  required>
                                            <option value="0" @selected(!$plan->featured)>{{ __('No') }}</option>
                                            <option value="1" @selected($plan->featured)>{{ __('Yes') }}</option>
                                        </select>
                                    </div>

                                    @foreach($features as $key => $value)
                                        @if($value['type'] == 'option')
                                            <div class="form-group">
                                                <label for="{{ $key }}" @class(['required' => $value['required']])>
                                                    {{ ucfirst(str_replace('_',' ',$key)) }}
                                                </label>

                                                <select name="meta[{{ $key }}]" id="{{ $key }}" class="form-control" data-control="select2" @if($value['required']) required @endif>
                                                    @foreach($value['value'] ?? [] as $k => $row)
                                                        <option value="{{ $row }}" @selected($plan->$key == $row)>{{ $k }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @elseif($value['type'] == 'textarea')
                                            <div class="form-group">
                                                <label for="{{ $key }}">{{ ucfirst(str_replace('_',' ',$key)) }}</label>
                                                <textarea name="meta[{{ $key }}]" id="{{ $key }}" class="form-control">{{ $plan->$key }}</textarea>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label for="{{ $key }}" @class(['required' => $value['required']])>
                                                    {{ ucfirst(str_replace('_',' ',$key)) }}
                                                    {{ $key == 'storage_limit' ? "(MB)" : '' }}
                                                </label>
                                                <input type="{{ $value['type'] }}" name="meta[{{ $key }}]" id="{{ $key }}"
                                                       class="form-control" value="{{ $plan->$key }}" @if($value['required']) required @endif>
                                            </div>
                                        @endif
                                    @endforeach

                                    <div class="form-group">
                                        <button class="btn btn-primary basicbtn">
                                            <i class="fas fa-save"></i>
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
