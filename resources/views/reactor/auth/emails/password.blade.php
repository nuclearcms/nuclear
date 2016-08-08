@extends('layout.email')

@section('pageTitle', trans('passwords.reset_password'))

@section('content')
    <h3>{{ trans('general.hello') }}!</h3>
    <p>{{ trans('passwords.reset_requested') }}</p>
    {!! link_to_route('reactor.password.reset', null, [
        'token' => $token,
        'email' => urlencode($user->getEmailForPasswordReset())
    ]) !!}
    <p>{{ trans('passwords.ignore') }}</p>

    <p>{{ trans('general.thank_you') }}!</p>
@endsection
