@extends('layout.form')

@section('pageTitle', trans('users.create'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-user-add') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection