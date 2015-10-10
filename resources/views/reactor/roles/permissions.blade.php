@extends('layout.content')

@section('pageTitle', trans('users.permissions'))
@section('contentSubtitle')
    <a href="/reactor/roles">
        {{ uppercase(trans('users.roles')) }}
    </a>
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $role->label,
        'headerHint' => $role->name
    ])

    <div class="material-light">
        <ul class="content-tabs-bar">
            <li>
                <a href="/reactor/roles/{{ $role->getKey() }}/edit" class="content-tab-flap">{{ uppercase(trans('users.role')) }}</a>
            </li><li>
                <span class="content-tab-flap active">{{ uppercase(trans('users.permissions')) }}</span>
            </li><li>
                <a href="/reactor/roles/{{ $role->getKey() }}/users" class="content-tab-flap">{{ uppercase(trans('users.title')) }}</a>
            </li>
        </ul>
        @include('permissions.subtable', ['permissions' => $role->permissions])

        {{-- @include('permissions.subform', [
            'permissions' => $permissions->diff($role->permissions)
        ])--}}
    </div>

@endsection