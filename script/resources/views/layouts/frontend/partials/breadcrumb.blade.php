<!-- Breadcrumb Area -->
<div class="breadcrumb-area" style="background-image:url('{{ asset('frontend/img/bg-img/1.jpg') }}')">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content-text">
                    <h6>@isset($title) {{ $title }}@else @yield('title')@endisset</h6>
                    @isset($description)
                        <h3>{{ $description }}</h3>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area -->
