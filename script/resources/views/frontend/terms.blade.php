@extends('layouts.frontend.app')

@section('title', __('Terms of Service'))

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.terms')])

    <div class="terms-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="terms-content-text">
                        {!! $term['content'] ?? null !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
