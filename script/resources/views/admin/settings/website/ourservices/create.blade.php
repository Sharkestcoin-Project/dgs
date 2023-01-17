@extends('layouts.backend.app',[
     'prev'=> route('admin.settings.website.our-services.index')
])

@section('title', __('Create Service'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form class="ajaxform_with_reset" method="post" action="{{ route('admin.settings.website.our-services.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="lang" class="required">{{ __('Language') }}</label>
                            <select name="lang" id="lang" class="form-control" data-control="select2" data-placeholder="Select Language" required>
                                <option></option>
                                @foreach($languages->value as $key => $lang)
                                    <option value="{{ $key }}" @selected($key == current_locale())>{{ $lang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="icon" class="required">{{ __('Icon') }}</label>
                            <input type="text" name="icon" id="icon" class="form-control" placeholder="fas fa-home" required>
                        </div>

                        <div class="form-group">
                            <label for="title" class="required">{{ __('Title') }}</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="required">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
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
