@extends('layouts.user.app', [
    'prev' => route('user.products.index')
])

@section('title', __('Product links'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="d-inline-block">{{ __('EMBED ON YOUR SITE') }}</h6>
            </div>
            <div class="shadow p-3 border-1 mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="d-inline-block">{{ __('FOR WEB PAGE') }}</h6>
                    <button type="button" class="btn btn-primary btn-sm copyLinkBtn" id="copyLinkBtn" data-id="{{ '<iframe height="330px" width="50%" class="main-ifram" src="'.route('product.iframe', $product->id).'" frameborder="0"></iframe>' }}"> {{ __('copy') }}</button>
                </div>
                <div>
                    <textarea class="form-control bg-dark text-light text-nowrap" id="pageLink">{{ '<iframe height="330px" width="50%" class="main-ifram" src="'.route('product.iframe', $product->id).'" frameborder="0"></iframe>' }}</textarea>
                </div>
            </div>

            <div class="shadow p-3 border-1 mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="d-inline-block">{{ __('LINK') }}</h6>
                    <button type="button" class="btn btn-primary btn-sm productLink" id="productLink" data-id="{{ route('products.show', $product->id) }}"> {{ __('copy') }}</button>
                </div>
                <div>
                    <textarea class="form-control bg-dark text-light text-nowrap" id="pageLink">{{ route('products.show', $product->id) }}</textarea>
                </div>
            </div>

            <div class="shadow p-3 border-1 mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="d-inline-block">{{ __('FOR NEW WINDOW') }}</h6>
                    <button type="button" class="btn btn-primary btn-sm windowLinkCopy" id="windowLinkCopy" data-id="{{ '<a href="'. route('products.show', $product->id) .'" onclick="javascript:window.open(\''.route('products.show', $product->id).'\', \'WIPaypal\', \'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=860, height=700\'); return false;" style="padding: 10px 20px;border-radius: 5px;text-decoration: none;background: #007bff; color: #FFF;">Buy Now</a>' }}"> {{ __('copy') }}</button>
                </div>
                <div>
                    <textarea class="form-control bg-dark text-light text-nowrap" id="buttonLink">{{ '<a href="'. route('products.show', $product->id) .'" onclick="javascript:window.open(\''.route('products.show', $product->id).'\', \'WIPaypal\', \'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=860, height=700\'); return false;" style="padding: 10px 20px;border-radius: 5px;text-decoration: none;background: #007bff; color: #FFF;">Buy Now</a>' }}</textarea>
                </div>
            </div>

            <div class="shadow p-3 border-1 mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="d-inline-block">{{ __('FOR MODAL') }}</h6>
                    <button type="button" class="btn btn-primary btn-sm buttonLinkCopy" id="buttonLinkCopy" data-id="{{ '<a href="#" id="mySizeChart">Buy Now</a>
                        <div id="mySizeChartModal" class="ebcf_modal d-none">
                            <div class="ebcf_modal-content" id="ebcf_modal_content">
                                <span class="ebcf_close">&times;</span>
                                <iframe height="330px" width="100%" class="main-ifram" src="'.route('product.iframe', $product->id).'" frameborder="0"></iframe>
                            </div>
                        </div>' }} {{ "<script src='".asset('frontend/js/iframe.js')."'></script>" }}"> {{ __('copy') }}</button>
                </div>
                <div>
                    <textarea class="form-control bg-dark text-light text-nowrap codes" id="buttonLink">{{ '<a href="#" id="mySizeChart">Buy Now</a>
                        <div id="mySizeChartModal" class="ebcf_modal d-none">
                            <div class="ebcf_modal-content" id="ebcf_modal_content">
                                <span class="ebcf_close">&times;</span>
                                <iframe height="330px" width="100%" class="main-ifram" src="'.route('product.iframe', $product->id).'" frameborder="0"></iframe>
                            </div>
                        </div>' }} {{ "<script src='".asset('frontend/js/iframe.js')."'></script>" }}</textarea>
                </div>
            </div>

        </div>
    </div>
@endsection
