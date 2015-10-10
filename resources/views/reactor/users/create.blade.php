@extends('layout.form')

@section('pageTitle', trans('users.create'))
@section('contentSubtitle')
    <a href="/reactor/users">
        {{ uppercase(trans('users.title')) }}
    </a>
@endsection

@section('action')
    {!! submit_button('icon-user-add') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection