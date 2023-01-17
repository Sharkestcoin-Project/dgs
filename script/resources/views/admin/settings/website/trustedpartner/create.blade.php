@extends('layouts.backend.app',[
     'prev'=> route('admin.settings.website.trusted-partner.index')
])

@section('title', __('Create Trusted Partner'))


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form class="ajaxform_with_reset" method="post" action="{{ route('admin.settings.website.trusted-partner.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="title" class="required">{{ __('Title') }}</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="image" class="required">{{ __('Image') }}</label>
                            {{ mediasection([
                                'input_name' => 'image',
                                'input_id' => 'image'
                            ]) }}
                        </div>


                        <div class="form-group">
                            <label for="website_link" class="required">{{ __('Website Link') }}</label>
                            <input type="url" name="website_link" id="website_link" class="form-control" required>
                        </div>

                        <button class="btn btn-primary basicbtn">
                            <i class="fas fa-save"></i>
                            {{ __('Save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    {{ mediasingle() }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/custom/media.js') }}"></script>
@endpush
