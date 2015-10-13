@extends('layout.content')

@section('pageTitle', trans('users.permissions'))
@section('contentSubtitle')
    {!! link_to_route('reactor.roles.index', uppercase(trans('users.roles'))) !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $model->label,
        'headerHint' => $model->name
    ])

    <div class="material-light">
        @include('roles.tabs', [
            'currentTab' => 'reactor.roles.permissions',
            'currentKey' => $model->getKey()
        ])

        @include('permissions.subtable', [
            'permissions' => $model->permissions,
            'route' => route('reactor.roles.permission.remove', $model->getKey())
        ])

        @include('permissions.add')

    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_unlink_permission'])