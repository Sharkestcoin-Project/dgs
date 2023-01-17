@extends('layouts.user.app')

@section('title', __('Update account setting'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('user.settings.store') }}" method="post" class="ajaxform">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __("UPDATE YOUR/STORE DETAILS") }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('user.settings.subscriptions.index') }}" class="btn btn-primary">{{ __('Billing') }}</a>
                        </div>
                      </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('NAME') }}</label>
                                    <input type="text" class="form-control" name="name" placeholder="Your name" value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('EMAIL ADDRESS') }}</label>
                                    <input type="text" class="form-control" name="email" placeholder="yourmail@gmail.com" value="{{ auth()->user()->email }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('PASSWORD') }}</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('CONFIRM PASSWORD') }}</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('STORE NAME') }}</label>
                                    <input type="text" class="form-control" name="store_name" placeholder="Your store name" required value="{{ auth()->user()->meta['store_name'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('SUPPORT EMAIL ADDRESS') }}</label>
                                    <input type="email" class="form-control" name="support_email" placeholder="Store support mail" value="{{ auth()->user()->meta['support_email'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('STREET ADDRESS') }}</label>
                                    <input type="text" class="form-control" name="shop_address" placeholder="Store street address" value="{{ auth()->user()->meta['shop_address'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('CITY') }}</label>
                                    <input type="text" class="form-control" name="city" placeholder="New York" value="{{ auth()->user()->meta['city'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('STATE/PROVINCE') }}</label>
                                    <input type="text" class="form-control" placeholder="NY" name="state" value="{{ auth()->user()->meta['state'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="mb-0">{{ __('POSTAL CODE') }}</label>
                                    <input type="number" class="form-control" name="postal_code" placeholder="10458" value="{{ auth()->user()->meta['postal_code'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6 align-self-center">
                                <div class="justify-content-center text-center">
                                    @if (auth()->user()->meta['store_logo'] ?? false)
                                    <img src="{{ asset(auth()->user()->meta['store_logo']) }}" alt="" id="cover_photo_parent_preview" class="card-img rounded-0" width="200">
                                    @else
                                    <img src="{{ asset('admin/img/img/placeholder.png') }}" alt="" id="cover_photo_parent_preview" class="rounded-0" width="200">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="cover_local" class="btn btn-primary text-white d-block rounded-pill cursor-pointer">
                                        <i class="fas fa-image"></i> {{ __('Chose Logo') }}
                                    </label>

                                    <input type="file" name="cover_local" id="cover_local" hidden accept="image/*">
                                    <input type="hidden" name="store_logo" id="cover" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row text-right">
                            <div class="col">
                                <button class="btn btn-primary basicbtn"><i class="fas fa-save"></i> {{ __('SAVE CHANGES') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="photo_cropper_modal" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group overflow-auto">
                        <img class="max-w-100" src="" alt="" id="previewImage">
                    </div>

                    <div class="form-group">
                        <button type="button" id="btnCrop" class="btn btn-primary btn-lg btn-block">{{ __('Crop') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/cropperjs/cropper.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/cropperjs/cropper.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropperjs/jquerycropper.min.js') }}"></script>
    <script src="{{ asset('admin/custom/user/coverphoto.js') }}"></script>
@endpush
