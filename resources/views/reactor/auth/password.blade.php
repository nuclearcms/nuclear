@extends('auth.layout')

@section('pageTitle', trans('passwords.reset_password'))

@section('content')
    <h2>{{ trans('passwords.reset_password') }}</h2>
    @if(session()->has('status'))
        <p class="auth-success">
            {{ session('status')  }}
        </p>
    @else
        @include('auth.error')
    @endif

    <form class="auth-form-space" method="POST" action="/reactor/password/email">
        {!! csrf_field() !!}

        <div class="form-group form-group-icon-label">
            <input type="email" name="email" id="email" placeholder="{{ trans('validation.attributes.email') }}" value="{{ old('email') }}" required>
            <label class="icon-label" for="email">
                <i class="icon-mail"></i>
            </label>
        </div>

        <div class="auth-buttons">
            {!! submit_button('icon-lock', 'passwords.send_link') !!}
        </div>
    </form>
    <div class="auth-option">
        <a href="/reactor/auth/login"><i class="icon-left-open-big"></i>{{ trans('passwords.back_to_login') }}</a>
    </div>
@endsection