@extends('layout.form')

@section('pageTitle', trans('users.edit_permission'))
@section('contentSubtitle')
    {!! link_to_route('reactor.permissions.index', uppercase(trans('users.permissions'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $permission->name
    ])

    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>

@endsection