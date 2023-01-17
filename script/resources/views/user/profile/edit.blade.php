@extends('layouts.user.app')

@section('title', __('Edit Profile'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form action="{{ route('user.profile.update') }}" method="post" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>{{ __('Edit Profile') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 justify-content-center text-center">
                                <img src="{{ asset(auth()->user()->avatar ?? 'admin/img/img/placeholder.png') }}" alt="" id="avatar_photo_parent_preview" class="rounded-0" width="200">
                            </div>
                            <div class="form-group col-12 mt-3">
                                <label for="avatar_local" class="btn btn-primary text-white d-block rounded-0 cursor-pointer">
                                    {{ __('Upload Profile Photo') }}
                                </label>
                                <input type="file" name="avatar_local" id="avatar_local" accept="image/*" hidden>
                                <input type="hidden" name="avatar" id="avatar" class="form-control" required>
                            </div>

                            <div class="col-12 justify-content-center text-center">
                                <img src="{{ asset(auth()->user()->meta['cover_img'] ?? 'admin/img/img/placeholder.png') }}" alt="" id="cover_photo_parent_preview" class="rounded-0" width="200">
                            </div>
                            <div class="form-group col-12 mt-3">
                                <label for="cover_local" class="btn btn-primary text-white d-block rounded-0 cursor-pointer">
                                    {{ __('Cover Photo') }}
                                </label>
                                <input type="file" name="cover_local" id="cover_local" accept="image/*" hidden>
                                <input type="hidden" name="cover" id="cover" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label for="name" class="required">{{ __('Full Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="email" class="required">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="phone" class="required">{{ __('Phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="password">{{ __('Change Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <small class="text-secondary">{{ __('If you do not want to change the password, leave it blank') }}</small>
                            </div>
                        </div>

                        @if(config('newsletter.apiKey') && config('newsletter.lists.subscribers.id'))
                        <div class="row">
                            <div class="form-group mb-0 col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="newsletter" class="custom-control-input" id="newsletter" @checked(Newsletter::isSubscribed(Auth::user()->email))>
                                    <label class="custom-control-label" for="newsletter">{{ __('Subscribe to newsletter') }}</label>
                                    <div class="text-muted form-text">
                                        {{ __('You will get new information about products, offers and promotions') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary basicbtn"><i class="fas fa-save"></i> {{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="profile_cropper_modal" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group overflow-auto">
                    <img class="max-w-100" src="" alt="" id="profilePreviewImage">
                </div>

                <div class="form-group">
                    <button type="button" id="profileBtnCrop" class="btn btn-primary btn-lg btn-block">{{ __('Crop') }}</button>
                </div>
            </div>
        </div>
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
<script src="{{ asset('admin/custom/user/profilephoto.js') }}"></script>
<script src="{{ asset('admin/custom/user/createproduct.js') }}"></script>
@endpush
