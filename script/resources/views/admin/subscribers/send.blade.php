@extends('layouts.backend.app', [
    'prev'=> route('admin.subscribers.index')
])

@section('title', __('Send Email to Subscribers'))

@section('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
@endsection

@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <form class="ajaxform" method="post" action="{{ route('admin.subscribers.queue') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3" id="parent">
                                <label for="to" class="required">{{ __('To') }}</label>
                                <br>
                                <small>{{ __('Leave empty to send email to all user') }}</small>
                                <select name="to[]" id="to" class="form-control" multiple></select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="subject" class="required">{{ __('Subject') }}</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="{{ __('Enter email subject') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="body" class="required">{{ __('Body') }}</label>
                                <textarea name="body" id="subject" class="summernote"></textarea>
                            </div>

                            <button class="btn btn-primary float-right"><i class="fas fa-paper-plane"></i> {{ __('Send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/summernote-bs4.js') }}"></script>
    <script src="{{ asset('admin/assets/js/summernote.js') }}"></script>
    <script src="{{ asset('admin/js/pages/subscribers/send.js') }}"></script>
@endpush
