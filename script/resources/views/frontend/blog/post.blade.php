@extends('layouts.frontend.app')

@section('title', $post->title)

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.post')])

    <!-- Blog Details Area -->
    <div class="blog-details-area section-padding-100-50">
        <div class="container">
            <div class="row">
                <!-- Content Text -->
                <div class="col-lg-8">
                    <div class="blog-details-content mb-50">
                        <div class="blog-details-image">
                            <img src="{{ $post->preview->value ?? asset('admin/img/img/placeholder.png') }}" alt="">
                        </div>

                        <h2>{{ $post->title ?? null }}</h2>

                        <h5>{{ $post->excerpt->value ?? null }}</h5>

                        {{ content_format($post->description->value ?? null) }}

                        <div class="blog-details-tag row">
                            <div class="col-sm-6">

                                @if(isset($post->metatag->value))
                                <!-- tags start -->
                                <div class="tags-details d-flex align-items-center">
                                    <h4 class="font-weight-medium mb-0 mr-3">{{ __('Tags:') }}</h4>
                                    @foreach(str($post->metatag->value)->explode(',') as $tag)
                                        <a class="text-muted mr-1" href="{{ route('blog.index', ['tag' => trim($tag)]) }}">{{ $tag }}</a>
                                        @if(!$loop->last)
                                            , &nbsp;
                                        @endif
                                    @endforeach
                                </div>
                                <!-- tags end -->
                                @endif

                            </div>
                            <div class="col-sm-6">

                                <!-- share start -->
                                <div class="tags-details d-flex align-items-center justify-content-end">
                                    <h4 class="font-weight-medium mb-0 mr-3">{{ __('Share:') }}</h4>
                                    <div id="social-share"></div>
                                </div>
                                <!-- share end -->
                            </div>

                            <div class="col-md-12">
                                {{ disquscomment() }}
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Side Blog Content -->
                <div class="col-lg-4">
                    <div class="side-blog-details-area">
                        <div class="single-side-content">
                            <form action="{{ route('blog.index') }}" method="get">
                                <div class="form-outline">
                                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Type &amp; Search" required="">
                                </div>
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>

                        <div class="single-side-content-card">
                            <div class="single-side-content">
                                <h4 class="side-blog-title">{{ __('- Recent post') }}</h4>
                                <div class="recent-post-area">
                                    @foreach($recentPosts as $recentPost)
                                        <!-- Single Post -->
                                        <div class="single-recent-post d-lg-flex align-items-center">
                                            <div class="recent-post-img">
                                                <img src="{{ $recentPost->preview->value ?? asset('admin/img/img/placeholder.png') }}" alt="">
                                            </div>

                                            <div class="recent-post-text">
                                                <h5><a href="{{ route('blog.post', $recentPost->slug) }}">{{ $recentPost->title }} </a></h5>
                                                <span class="recent-post-date">{{ formatted_date($recentPost->created_at, 'M d, Y') }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/jssocials-1.4.0/jssocials.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/jssocials-1.4.0/jssocials-theme-flat.css') }}" />
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
    <script src="{{ asset('admin/plugins/jssocials-1.4.0/jssocials.min.js') }}"></script>
    <script>
        "use strict";
        $("#social-share").jsSocials({
            shares: ["twitter", "facebook", "googleplus", "linkedin"],
            url: "{{ route('blog.post', $post->slug) }}",
            text: "{{ $post->title }}",
            shareIn: "popup",
        });
    </script>
@endpush
