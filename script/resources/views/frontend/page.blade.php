@extends('layouts.frontend.app')

@section('title', $page->title)

@section('content')
<!-- Breadcrumb Area -->
<div class="breadcrumb-area" style="background-image:url('{{ asset('frontend/img/bg-img/1.jpg') }}')">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content-text">
                    <h6>{{ $page->title }}</h6>
                    <h3>{{ __('description.page') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area -->

<!-- All Product Area -->
<div class="all-product-area section-padding-100-50">
    <div class="container">
        {{ content_format(json_decode($page->pageMeta->value)->page_content) }}
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
