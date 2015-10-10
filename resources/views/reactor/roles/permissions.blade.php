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
        <ul class="content-tabs-bar">
            <li>
                {!! link_to_route('reactor.roles.edit', uppercase(trans('users.role')), $role->getKey(), ['class' => 'content-tab-flap']) !!}
            </li><li>
                <span class="content-tab-flap active">{{ uppercase(trans('users.permissions')) }}</span>
            </li><li>
                {!! link_to_route('reactor.roles.users', uppercase(trans('users.title')), $role->getKey(), ['class' => 'content-tab-flap']) !!}
            </li>
        </ul>
        @include('permissions.subtable', ['permissions' => $role->permissions])

        {{-- @include('permissions.subform', [
            'permissions' => $permissions->diff($role->permissions)
        ])--}}
    </div>

@endsection