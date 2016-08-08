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
            <label class="auth-buttons__button button form-group__checkbox">
                <input type="checkbox" name="remember">
                <span>
                    {{ uppercase(trans('auth.remember')) }}
                    <i class="icon-cancel button__icon button__icon--right"></i><i class="icon-confirm button__icon button__icon--right"></i>
                </span>
            </label>{!! submit_button('icon-login', trans('auth.login'), 'button--emphasis auth-buttons__button') !!}
        </div>

        <div class="modal-buttons modal-buttons--separated text--center">
            <a href="{{ route('reactor.password.email') }}" class="button">{{ uppercase(trans('auth.forgot')) }}</a>
        </div>
    </form>
@endsection