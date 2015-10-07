@extends('layout.form')

@section('pageTitle', trans('users.create'))
@section('contentSubtitle')
    <a href="/reactor/users">
        {{ uppercase(trans('users.title')) }}
    </a>
@endsection

@section('action')
    <button class="button button-emphasized button-icon-primary" type="submit">
        <i class="icon-user-add"></i>
    </button>
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection