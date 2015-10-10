@extends('layout.form')

@section('pageTitle', trans('users.create_role'))
@section('contentSubtitle')
    <a href="/reactor/roles">
        {{ uppercase(trans('users.roles')) }}
    </a>
@endsection

@section('action')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection