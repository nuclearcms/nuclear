@extends('layout.form')

@section('pageTitle', trans('users.create_role'))
@section('contentSubtitle')
    <a href="/reactor/roles">
        {{ uppercase(trans('users.roles')) }}
    </a>
@endsection

@section('action')
    <button class="button button-emphasized button-icon-primary" type="submit">
        <i class="icon-plus"></i>
    </button>
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection