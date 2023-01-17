@extends('layouts.backend.app')

@section('title', __('Demo Product Setting'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{ route('admin.settings.website.demo.update') }}" class="ajaxform" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Demo Product Setting') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">{{ __('Product Title') }}</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ $demo->title ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" name="description" class="form-control" required>{{ $demo->description ?? null }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="file">{{ __('File') }}</label>
                            <input type="file" id="file" name="file" class="form-control">
                            @if(isset($demo->file))
                                <a href="{{ route('admin.settings.website.demo.download') }}">{{ __('Old Demo Product') }}</a>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price">{{ __('Price') }}</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ $demo->price ?? null}}" required>
                        </div>

                        <div class="form-group">
                            <label for="product_cover">{{ __('Product Cover') }}</label>
                            {{ mediasection([
                                 'input_id' => 'product_cover',
                                 'input_name' => 'product_cover',
                                 'preview_class' => 'product_cover',
                                 'preview' => $demo->product_cover ?? null,
                                 'value' => $demo->product_cover ?? null
                             ]) }}
                        </div>

                        <div class="form-group">
                            <label for="user_name">{{ __('User Name') }}</label>
                            <input type="text" id="user_name" name="user_name" class="form-control" value="{{ $demo->user_name ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="user_avatar">{{ __('User Avatar') }}</label>
                            {{ mediasection([
                                 'input_id' => 'user_avatar',
                                 'input_name' => 'user_avatar',
                                 'preview_class' => 'user_avatar',
                                 'preview' => $demo->user_avatar ?? null,
                                 'value' => $demo->user_avatar ?? null
                             ]) }}
                        </div>

                        <button class="btn btn-primary basibtn">
                            <i class="fas fa-save"></i>
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('modal')
    {{ mediasingle() }}
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/custom/media.js ') }}"></script>
@endpush

