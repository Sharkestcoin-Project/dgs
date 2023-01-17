@extends('layouts.backend.app', [
     'prev' => route('admin.payout-methods.index'),
])

@section('title', __('New Payout Method'))

@section('content')
    <form method="post" action="{{ route('admin.payout-methods.store') }}" class="ajaxform_with_reset" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Method Name') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('Method Name') }}" required="" name="name">
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency_id">{{ __('Select Currency') }}</label>
                                    <select name="currency_id" id="currency_id" class="form-control" required>
                                        <option value="">-{{ __('Select') }}-</option>
                                        @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name. " (".$currency->rate.")" }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="transaction_fixed col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Delay') }}</label>
                                    <input type="number" class="form-control" name="delay" placeholder="{{ __('Delay') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Minimum Amount') }}</label>
                                    <input type="number" class="form-control" placeholder="{{ __('Minimum Amount') }}" required="" name="min_limit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Maximum Amount') }}</label>
                                    <input type="number" class="form-control" placeholder="{{ __('Maximum Amount') }}" required="" name="max_limit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Select Charge Type') }}</label>
                            <select name="charge_type" class="form-control" id="charge_type">
                                <option value="fixed">{{ __('Fixed') }}</option>
                                <option selected value="percentage">{{ __('Percentage') }}</option>
                            </select>
                        </div>
                        <!--- Transaction Charge Fixed --->
                        <div class="form-row">
                            <div class="transaction_fixed col-sm-12 d-none">
                                <div class="form-group">
                                    <label>{{ __('Fixed Amount') }}</label>
                                    <input type="number" class="form-control" name="fixed_charge" placeholder="Fixed Amount">
                                </div>
                            </div>
                            <!--- Transaction Charge percentage --->
                            <div class="transaction_percentage col-sm-12 d-none">
                                <div class="form-group">
                                    <label>{{ __('Percentage Amount') }}</label>
                                    <input type="number" class="form-control" name="percent_charge" placeholder="Percentage Amount">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Currency Image') }}</label>
                                    {{ mediasection() }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Instruction') }}</label>
                                    <textarea name="instruction" class="summernote"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group field_wrapper">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="">{{ __('Label') }}</label> <br>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ __('Input Type') }}</label><br>
                                </div>
                                <div class="col-md-1">
                                    <a href="javascript:" class="add_button text-xxs mr-2 btn btn-primary mb-0 btn-sm  text-xxs ">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><br>
                                    <input type="text" data-key="0" class="form-control" name="inputs[0][label]" placeholder="Label here">
                                </div>
                                <div class="col-md-6"><br>
                                    <select class="form-control" name="inputs[0][type]" id="">
                                        <option value="text">{{ __('Text') }}</option>
                                        <option value="number">{{ __('Number') }}</option>
                                        <option value="textarea">{{ __('Textarea') }}</option>
                                        <option value="email">{{ __('Email') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a href="javascript:void(0);" class="remove_button text-xxs mr-2 btn btn-danger mb-0 btn-sm  text-xxs mt-4" title="Remove">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="single-area">
                    <div class="card">
                        <div class="card-body">
                            <div class="btn-publish">
                                <button type="submit" class="btn btn-primary col-12 basicbtn"><i class="fa fa-save"></i>
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="btn-publish">
                            <div class="form-group">
                                <label>{{ __('Status') }}</label>
                                <select name="status" class="form-control ">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('modal')
{{ mediasingle() }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.css') }}">
@endpush

@push('script')
    <!-- JS Libraies -->
    <script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/custom/media.js') }}"></script>
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('admin/plugins/summernote/summernote.js') }}"></script>
    <script>
        "use strict";
        var x = 0; //Initial field counter is 1
        var count = 1;
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper

        //Once add button is clicked
        $(addButton).on('click', function() {
            //Check maximum number of input fields
            if (x < maxField) {
                //Increment field counter
                var fieldHTML = `<div class='row'><div class="col-md-5">
                      <br>
                      <input type="text" required class="form-control" name="inputs[${count}][label]" value="" placeholder="{{ __('Label here') }}">
                      </div>
                      <div class="col-md-6">
                        <br>
                          <select class="form-control" name="inputs[${count}][type]" id="">
                               <option value="text">{{ __('Text') }}</option>
                               <option value="number">{{ __('Number') }}</option>
                               <option value="textarea">{{ __('Textarea') }}</option>
                               <option value="email">{{ __('Email') }}</option>
                           </select>
                      </div>
                      <div class="col-md-1">
                          <a href="javascript:void(0);" class="remove_button text-xxs mr-2 btn btn-danger mb-0 btn-sm mt-4 text-xxs" title="Add field">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                              </svg>
                          </a>
                      </div><div>`; //New input field html
                x++;
                count++;
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div.row').remove(); //Remove field html
            x--; //Decrement field counter
        });
    </script>
@endpush
