@extends('layout.content')

@section('pageTitle', trans('users.roles'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName
    ])

    <div class="material-light">
        @include('users.tabs', [
            'currentTab' => 'reactor.users.roles',
            'currentKey' => $profile->getKey()
        ])

        @include('roles.subtable', [
            'roles' => $profile->roles,
            'route' => route('reactor.users.role.remove', $profile->getKey())
        ])

        @include('roles.add')

    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_unlink_role'])