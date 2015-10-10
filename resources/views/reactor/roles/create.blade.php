@extends('layout.form')

@section('pageTitle', trans('users.create_role'))
@section('contentSubtitle')
    {!! link_to_route('reactor.roles.index', uppercase(trans('users.roles'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection