@extends('layouts.backend.app', [
    'prev' => route('user.subscriptions.index'),
])

@section('title', __('Create Subscription'))

@section('content')

    <form action="{{ route('user.subscriptions.store') }}" method="post" class="ajaxform_with_redirect product-wizerd" id="subscription-form">
        @csrf

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="tab">
                            <div class="form-group">
                                <label for="name" class="required">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="currency" class="required">{{ __('Currency') }}</label>
                                <select name="currency" id="currency" data-control="select2" required>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->code }} - {{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="price" class="required">{{ __('Price') }}</label>
                                <input type="number" min="0" step="any" name="price" id="price" value="0.00" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="period" class="required">{{ __('Period') }}</label>
                                <select name="period" id="period" data-control="select2" required>
                                    <option value="weekly">{{ __('Weekly') }}</option>
                                    <option value="monthly" selected>{{ __('Monthly') }}</option>
                                    <option value="yearly">{{ __('Yearly') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="form-group">
                                <label for="return_url" class="optional">{{ __('Return Url') }}</label>
                                <input type="text" name="return_url" id="return_url" class="form-control" placeholder="Ex: https://www.facebook.com/my-page">
                            </div>
                            <div class="form-group">
                                <label for="description" class="required">{{ __('Description') }}</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="justify-content-center">
                                        <img src="{{ asset('admin/img/img/placeholder.png') }}" alt=""
                                            id="cover_photo_parent_preview" class="card-img rounded-0" height="200">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group">
                                        <label for="cover_local" class="btn btn-dark text-white d-block cursor-pointer">
                                            <i class="fas fa-upload"></i>
                                            {{ __('Upload Cover') }}
                                        </label>

                                        <input type="file" name="cover_local" id="cover_local" accept="image/*" hidden>
                                        <input type="hidden" name="cover" id="cover" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="form-group">
                                <label for="welcome_message" class="required">{{ __('Welcome Message') }}</label>
                                <textarea name="welcome_message" id="welcome_message" class="form-control" required>{{ __('Thanks for purchasing our subscription') }}</textarea>
                            </div>
                            <div class="card shadow-sm mb-3 repeater">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>{{ __('Features') }}</h4>

                                    <button type="button" class="btn btn-primary btn-sm" data-repeater-create>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="card-body" data-repeater-list="features">
                                    <div class="input-group mb-3" data-repeater-item>
                                        <input type="text" name="title" class="form-control" placeholder="{{ __('Feature title') }}" aria-label="{{ __('Features') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-danger" type="button" data-repeater-delete>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-5">
                            <div class="btn-group w-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-dark btn-sm text-light" id="prevBtn" onclick="nextPrev(-1)"><i class="fas fa-angle-double-left"></i> {{ __('Prev') }}</button>
                                <button type="button" class="btn btn-primary btn-sm basicbtn" id="nextBtn" onclick="nextPrev(1)">{{ __('Next') }} <i class="fas fa-angle-double-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('modal')
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
    <script src="{{ asset('admin/plugins/jqueryrepeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('user/js/subscription.js') }}"></script>
@endpush
