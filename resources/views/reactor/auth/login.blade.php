@extends('auth.layout')

@section('pageTitle', trans('auth.login'))

@section('content')
    <h2>{{ trans('auth.login') }}</h2>
    @include('auth.error')
    <form method="POST" action="{{ route('reactor.auth.login.post') }}">
        {!! csrf_field() !!}

        <div class="form-group form-group-icon-label">
            <input type="email" name="email" id="email" placeholder="{{ trans('validation.attributes.email') }}" value="{{ old('email') }}" required>
            <label class="icon-label" for="email">
                <i class="icon-mail"></i>
            </label>
        </div>

        <div class="form-group form-group-icon-label">
            <input type="password" name="password" id="password" placeholder="{{ trans('validation.attributes.password') }}" required>
            <label class="icon-label" for="password">
                <i class="icon-lock"></i>
            </label>
        </div>

        <div class="auth-buttons">
            <label class="button form-checkbox">
                <input type="checkbox" name="remember">
                <span>
                    {{ uppercase(trans('auth.remember')) }}
                    <i class="icon-cancel"></i><i class="icon-check"></i>
                </span>
            </label>
            {!! submit_button('icon-login', 'auth.login') !!}
        </div>
    </form>
    <div class="auth-option">
        {!! link_to_route('reactor.password.email', trans('auth.forgot')) !!}
    </div>
@endsection