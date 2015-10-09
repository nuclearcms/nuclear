@extends('layout.form')

@section('pageTitle', trans('users.edit_permission'))
@section('contentSubtitle')
    <a href="/reactor/permissions">
        {{ uppercase(trans('users.permissions')) }}
    </a>
@endsection

@section('action')
    <button class="button button-emphasized button-icon-primary" type="submit">
        <i class="icon-floppy"></i>
    </button>
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $permission->name
    ])

    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>

@endsection