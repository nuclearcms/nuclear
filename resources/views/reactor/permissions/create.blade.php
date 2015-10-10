@extends('layout.form')

@section('pageTitle', trans('users.create_permission'))
@section('contentSubtitle')
    <a href="/reactor/permissions">
        {{ uppercase(trans('users.permissions')) }}
    </a>
@endsection

@section('action')
    {!! submit_button('icon-list-add') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection