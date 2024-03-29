@extends('auth.master')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{ __('Login') }}</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="col-form-label text-md-right">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            <div class="text-center">
                <button type="submit" class="btn cta">
                    {{ __('Login') }}
                    <i class="fal fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@if (Route::has('password.request'))
    <div class="text-center">
        <a id="forgot_password" href="{{ route('password.request') }}">
            {{ __('Forgot Password?') }}
        </a>
    </div>
@endif
@endsection
