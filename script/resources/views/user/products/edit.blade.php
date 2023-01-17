@extends('layouts.user.app', [
    'prev' => route('user.products.index')
])

@section('title', __('Edit Product'))

@section('content')

<div class="row justify-content-center product-wizerd">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.products.update', $product->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_with_redirect" id="product_form">
                    @csrf
                    @method('PUT')

                    <div class="tab">
                        <div class="form-group">
                            <label for="name" class="required">{{ __('Product Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" placeholder="{{ __('Enter product name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="required">{{ __('Product Description') }}</label>
                            <input type="text" name="description" id="description" class="form-control" value="{{ $product->name }}" placeholder="{{ __('Enter product description') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="currency" class="required">{{ __('Currency') }}</label>
                            <select name="currency" id="currency" class="form-control" data-placeholder="{{ __('Select Currency') }}" required data-control="select2">
                                <option></option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected($currency->id == $product->currency_id)>
                                        {{ $currency->code }} ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price" class="required">{{ __('Price') }}</label>
                            <input type="number" step="any" name="price" id="price" class="form-control" value="{{ $product->price }}" min="0" placeholder="{{ __('Enter product price') }}" required>
                        </div>
                    </div>

                    <div class="tab">
                        <div class="justify-content-center mb-3">
                            <img src="{{ $product->cover ? asset($product->cover) : asset('admin/img/img/placeholder.png') }}" alt="" id="cover_photo_parent_preview" class="card-img rounded-0" width="500" height="300">
                        </div>
                        <div class="form-group">
                            <label for="cover_local" class="btn btn-primary text-white d-block rounded-0 cursor-pointer">
                                {{ __('Cover Photo') }}
                            </label>

                            <input type="file" name="cover_local" id="cover_local" hidden accept="image/*">
                            <input type="hidden" name="cover" id="cover" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="theme_color" class="required">{{ __('Theme Colo') }}</label>
                            <input type="color" name="theme_color" id="theme_color" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="return_url" class="optional">{{ __('Return URL') }}</label>
                            <input type="url" name="return_url" id="return_url" class="form-control" value="{{ $product->return_url }}">
                        </div>
                    </div>

                    <div class="tab">
                        <div class="form-group">
                            @if ($product->file && $product->orders()->count() < 1)
                                <label for="uploadFileModalButton" class="required uploadFileLable">{{ __('File') }}</label>
                                <br>
                                <div class="product_file">
                                    <button type="button" class="btn btn-primary w-100 rounded-0" id="uploadFileModalButton" data-toggle="modal" data-target="#fileModal">
                                        <i class="fas fa-upload"></i>
                                        {{ __('Upload File') }}
                                    </button>
                                    <input type="hidden" name="folder" id="folder" value="">
                                </div>
                            @endif

                            @if($product->file)
                                <span id="showName">
                                    @if ($product->orders()->count() < 1)
                                        <a href="javascript:void(0)" data-action="{{ route('user.products.destroy.file', $product->id) }}" class="delete-file-confirm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <span>{{ Arr::last(str($product->file)->explode('/')->toArray()) }}</span>
                                    @else
                                        <a href="{{ route('user.products.download', $product->id) }}" target="_blank">
                                            <i class="fas fa-download"></i>
                                            {{ Arr::last(str($product->file)->explode('/')->toArray()) }}
                                        </a>
                                    @endif
                                </span>
                            @elseif ($product->orders()->count() > 0 && $product->meta['direct_url'])
                                <label for="direct_url" class="required">{{ __('Direct URL') }}</label>
                                <input type="url" id="direct_url" class="form-control" readonly value="{{ $product->meta['direct_url'] ?? '' }}">
                            @else
                                <label for="direct_url" class="required">{{ __('Direct URL') }}</label>
                                <input type="url" name="direct_url" id="direct_url" class="form-control" value="{{ $product->meta['direct_url'] ?? '' }}">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="custom-switch">
                                    <input type="checkbox" name="buyer_can_set_price" id="buyer_can_set_price" class="custom-switch-input" @checked($product->buyer_can_set_price)>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">{{ __("Let Buyers set a price?") }}</span>
                                </label>
                            </div>
                            <div class="form-group  col-md-6">
                                <label class="custom-switch">
                                    <input type="checkbox" name="notify_previous_buyer" id="notify_previous_buyer" class="custom-switch-input"  @checked($product->notify_previous_buyer)>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">{{ __("Notify Previous Buyer?") }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <div class="btn-group w-100" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-dark btn-sm text-light" id="prevBtn" onclick="nextPrev(-1)"><i class="fas fa-angle-double-left"></i> {{ __('Prev') }}</button>
                            <button type="button" class="btn btn-primary btn-sm basicbtn" id="nextBtn" onclick="nextPrev(1)">{{ __('Next') }} <i class="fas fa-angle-double-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
    @if($product->orders()->count() < 1)
    <!-- Modal -->
    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">{{ __('Upload File') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body h-400">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4">
                            <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link has-icon preview-tab-button d-none" id="preview-tab" data-toggle="tab" href="#preview" role="tab" aria-selected="true">
                                        <i class="fas fa-play"></i>
                                        {{ __("Preview") }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link has-icon active" id="local-tab" data-toggle="tab" href="#local" role="tab" aria-selected="true">
                                        <i class="fas fa-desktop"></i>
                                        {{ __("Local Files") }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="direct-link-tab" data-toggle="tab" href="#direct-link" role="tab" aria-selected="false">
                                        <i class="fas fa-link"></i>
                                        {{ __('Direct Link') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="tab-content no-padding h-100" id="myTab2Content">
                                <div class="tab-pane fade" id="preview" role="tabpanel" aria-labelledby="preview-tab">
                                    <div class="empty-state preview-file">

                                    </div>
                                </div>

                                <div class="tab-pane fade show active" id="local" role="tabpanel" aria-labelledby="local-tab">
                                    <div class="empty-state">
                                        <label for="uploadFromLocal" class="btn btn-primary required cursor-pointer">
                                            <i class="fas fa-desktop"></i>
                                            {{ __('Choose File') }}
                                        </label>
                                        <input type="file" id="uploadFromLocal" hidden accept="application/zip">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="direct-link" role="tabpanel" aria-labelledby="direct-link-tab">
                                    <div class="empty-state">
                                        <h1>{{ __('Files from the Web') }}</h1>
                                        <h6 class="lead">
                                            {{ __('Grab any file off the web.') }}
                                            <br>
                                            {{ __('Just provide the link.') }}
                                        </h6>
                                        <div class="form-group w-100">
                                            <div class="input-group mb-3">
                                                <input type="url" id="directUrl" class="form-control" placeholder="{{ __('Paste you link here...') }}" value="{{ $product->meta['direct_url'] }}">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary basicbtn" id="uploadFromUrlButton">
                                                        {{ __('Upload') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="modal fade" tabindex="-1" role="dialog" id="photo_cropper_modal" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group overflow-auto">
                        <img class="max-w-100" src="" alt="" id="previewImage">
                    </div>

                    <div class="form-group">
                        <button type="button" id="btnCrop" class="btn btn-primary btn-lg btn-block">{{ __('Crop') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/cropperjs/cropper.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/plugins/cropperjs/cropper.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropperjs/jquerycropper.min.js') }}"></script>
    <script src="{{ asset('admin/custom/user/coverphoto.js') }}"></script>
    <script src="{{ asset('admin/custom/user/editproduct.js') }}"></script>
@endpush
