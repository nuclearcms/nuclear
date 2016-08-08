@extends('auth.layout')

@section('pageTitle', trans('passwords.reset_password'))

@section('content')

    @if(session('status'))
    <p class="auth-message text--sm text--emphasis">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('reactor.password.email.post') }}">
    {!! csrf_field() !!}

        <div class="form-group-auth">
            <i class="icon-envelope"></i>
            {!! Form::text('email', null, ['placeholder' => trans('validation.attributes.email')]) !!}
        </div>

        <div class="auth-buttons">
            {!! submit_button('icon-envelope', trans('passwords.send_reset_link'), 'button--emphasis auth-buttons__button auth-buttons__button--full') !!}
        </div>

        <div class="modal-buttons modal-buttons--separated text--center">
            <a href="{{ route('reactor.auth.login') }}" class="button"><i class="button__icon button__icon--left icon-arrow-left"></i> {{ uppercase(trans('passwords.back_to_login')) }}</a>
        </div>

    </form>
@endsection