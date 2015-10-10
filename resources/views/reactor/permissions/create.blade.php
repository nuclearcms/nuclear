@extends('layout.form')

@section('pageTitle', trans('users.create_permission'))
@section('contentSubtitle')
    {!! link_to_route('reactor.permissions.index', uppercase(trans('users.permissions'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-list-add') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection