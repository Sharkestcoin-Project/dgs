@extends('layouts.backend.app', [
    'prev'=> route('admin.seo.index')
])

@section('title', __('Edit SEO Settings'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <form method="POST" action="{{ route('admin.seo.update',$data->id) }}"
                            class="ajaxform">
                            @method("PUT")
                            @csrf
                            <div class="card-body">

                                <div class="form-group row mb-4">
                                    <label class="text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Image') }}</label>
                                    <div class="col-sm-12 col-md-7">
                                        {{ mediasection(['input_name' => 'image', 'input_id' => 'image', 'preview' => $data->value['meta_image'] ?? '', 'value' => $data->value['meta_image'] ?? '']) }}
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="text-md-right col-12 col-md-3 col-lg-3 required">{{ __('Site Name') }}</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="site_name" value="{{ $data->value['site_name'] }}" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class=" text-md-right col-12 col-md-3 col-lg-3 required">{{ __('Meta Tag Name') }}</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="matatag" value="{{ $data->value['matatag'] ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label
                                        class=" text-md-right col-12 col-md-3 col-lg-3 required">{{ __('Twitter Site Title') }}</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="twitter_site_title" value="{{ $data->value['twitter_site_title'] ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class=" text-md-right col-12 col-md-3 col-lg-3 required">{{ __('Meta Description') }}</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea name="matadescription" id="" cols="30" rows="20" class="form-control" required>{{ $data->value['matadescription'] ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary basicbtn w-100 btn-lg" type="submit">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ mediasingle() }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/custom/media.js') }}"></script>
@endpush
