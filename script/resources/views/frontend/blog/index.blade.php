@extends('layouts.frontend.app')

@section('title', __('Blog'))

@section('seo')
    {!! SEO::generate() !!}
@endsection

@section('content')
    @include('layouts.frontend.partials.breadcrumb', ['description' => __('description.blog')])

    <!-- Blog Area -->
    <div class="blog-area section-padding-100-50">
        <div class="container">
            @if(isset($heading))
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="heading-title text-center">
                            <h3>{{ $heading['title'] ?? null }}</h3>
                            <p>{{ $heading['description'] ?? null }}</p>
                        </div>
                    </div>
                </div>

                @if(request('q') !== null)
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{ __('Search Result For: :query', ['query' => request('q')]) }}</strong>
                        </div>
                    </div>
                @endif

                @if(request('tag') !== null)
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <strong>{{ __('Result For: :tag', ['tag' => request('tag')]) }}</strong>
                        </div>
                    </div>
                @endif

                @if(isset($blog) && count($blog) > 0)
                    <div class="row">
                        @foreach($blog as $post)
                            <!-- Single Blog -->
                            <div class="col-md-6 col-lg-4">
                                <div class="single-blog-area mb-50">
                                    <div class="blog-image">
                                        <img src="{{ $post->preview->value ?? asset('admin/img/img/placeholder.png') }}" alt="">
                                    </div>
                                    <span class="blog-badge">{{ __('Update') }}</span>
                                    <h4>{{ $post->title }}</h4>
                                    <p>{{ $post->excerpt->value ?? null }}</p>
                                    <div class="blog-btn">
                                        <a href="{{ route('blog.post', $post->slug) }}">
                                            {{ __('Read more') }}
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $blog->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @else
                    <x-admin-can-update
                        :text="__('Create a post')"
                        :url="route('admin.blog.create')"
                    />
                @endif
            @else
                <x-admin-can-update
                    :text="__('Edit Latest News Section')"
                    :url="route('admin.settings.website.heading.index', ['trigger' => 'latest-news-tab'])"
                />
            @endif
        </div>
    </div>
    <!-- Blog Area -->
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/jqueryvalidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/custom/form.js') }}"></script>
@endpush
