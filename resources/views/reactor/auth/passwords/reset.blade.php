@extends('auth.layout')

@section('pageTitle', trans('passwords.reset_password'))

@section('content')

    <form method="POST" action="{{ route('reactor.password.reset.post') }}">
        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group-auth">
            <i class="icon-envelope"></i>
            {!! Form::text('email', urldecode($email) ?: old('email'), ['placeholder' => trans('validation.attributes.email')]) !!}
        </div>

        <div class="form-group-auth">
            <i class="icon-lock"></i>
            {!! Form::password('password', ['placeholder' => trans('validation.attributes.password')]) !!}
        </div>

        <div class="form-group-auth">
            <i class="icon-lock"></i>
            {!! Form::password('password_confirmation', ['placeholder' => trans('validation.attributes.password_confirmation')]) !!}
        </div>

        <div class="auth-buttons">
            {!! submit_button('icon-envelope', trans('passwords.reset_password'), 'button--emphasis auth-buttons__button auth-buttons__button--full') !!}
        </div>

        <div class="modal-buttons modal-buttons--separated text--center">
            <a href="{{ route('reactor.auth.login') }}" class="button"><i class="button__icon button__icon--left icon-arrow-left"></i> {{ uppercase(trans('passwords.back_to_login')) }}</a>
        </div>

    </form>
@endsection