@extends('layout.content')

@section('pageTitle', trans('users.permissions'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $model->present()->fullName
    ])

    <div class="material-light">
        @include('users.tabs', [
            'currentTab' => 'reactor.users.permissions',
            'currentKey' => $model->getKey()
        ])

        @include('permissions.subtable', [
            'permissions' => $model->permissions,
            'route' => route('reactor.users.permission.remove', $model->getKey())
        ])

        @include('permissions.add')

    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_unlink_permission'])