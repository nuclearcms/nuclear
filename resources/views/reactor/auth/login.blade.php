@extends('auth.layout')

@section('pageTitle', trans('auth.login'))

@section('content')
    <form method="POST" action="{{ route('reactor.auth.login.post') }}">
        {!! csrf_field() !!}

        <div class="form-group-auth">
            <i class="icon-envelope"></i>
            {!! Form::text('email', null, ['placeholder' => trans('validation.attributes.email')]) !!}
        </div>

        <div class="form-group-auth">
            <i class="icon-lock"></i>
            {!! Form::password('password', ['placeholder' => trans('validation.attributes.password')]) !!}
        </div>

        <div class="auth-buttons">
            {!! submit_button('icon-login', trans('auth.login')) !!}
        </div>

        <div class="modal-buttons modal-buttons--separated text--center">
            <a href="{{ route('reactor.password.email') }}" class="button">{{ uppercase(trans('auth.forgot')) }}</a>
        </div>
    </form>
@endsection