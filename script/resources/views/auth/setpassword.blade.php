@extends('auth.main')
@section('content')
    <div class="card-header">
        <h4>{{ __('Set Password') }}</h4>
    </div>
    <div class="card-body">

        @if(Session::has('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <form method="POST" id="ajaxform" class="needs-validation" action="{{ route('user.set-password.store', $event->slug) }}">
            @csrf

            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">{{ __('Password') }}</label>
                </div>
                <input type="password" name="password" id="password"
                       class="form-control  @error('password') is-invalid @enderror" required
                       autocomplete="current-password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="d-block">
                    <label for="password_confirmation" class="control-label">{{ __('Confirm Password') }}</label>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control  @error('confirmation_password') is-invalid @enderror" required
                       autocomplete="current-password">
                @error('confirmation_password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    {{ __('Set Password') }}
                </button>
            </div>
        </form>

        <div class="simple-footer">
            {{ __('Copyright') }} &copy; {{ Config::get('app.name') }} {{ date('Y') }}
        </div>
    </div>
@endsection



