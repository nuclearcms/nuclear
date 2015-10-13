@extends('layout.content')

@section('pageTitle', trans('users.title'))
@section('contentSubtitle')
    {!! link_to_route('reactor.roles.index', uppercase(trans('users.roles'))) !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $role->label,
        'headerHint' => $role->name
    ])

    <div class="material-light">
        @include('roles.tabs', [
            'currentTab' => 'reactor.roles.users',
            'currentKey' => $role->getKey()
        ])

        @include('users.subtable', ['users' => $role->users])

        @include('users.add')
    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_unlink_user'])