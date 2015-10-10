@extends('layout.content')

@section('pageTitle', trans('users.permissions'))
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
            'currentTab' => 'reactor.roles.permissions',
            'currentKey' => $role->getKey()
        ])

        @include('permissions.subtable', ['permissions' => $role->permissions])

        {{-- @include('permissions.subform', [
            'permissions' => $permissions->diff($role->permissions)
        ])--}}
    </div>

@endsection