@extends('layout.form')

@section('pageTitle', trans('users.edit_permission'))
@section('contentSubtitle')
    <a href="/reactor/permissions">
        {{ uppercase(trans('users.permissions')) }}
    </a>
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