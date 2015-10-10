@extends('layout.form')

@section('pageTitle', trans('users.edit_role'))
@section('contentSubtitle')
    {!! link_to_route('reactor.roles.index', uppercase(trans('users.roles'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $role->label,
        'headerHint' => $role->name
    ])

    <div class="material-light">
        @include('roles.tabs', [
            'currentTab' => 'reactor.roles.edit',
            'currentKey' => $role->getKey()
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection