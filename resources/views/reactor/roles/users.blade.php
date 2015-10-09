@extends('layout.content')

@section('pageTitle', trans('users.title'))
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
                <a href="/reactor/roles/{{ $role->getKey() }}/permissions" class="content-tab-flap">{{ uppercase(trans('users.permissions')) }}</a>
            </li><li>
                <span class="content-tab-flap active">{{ uppercase(trans('users.title')) }}</span>
            </li>
        </ul>
        @include('users.subtable', ['users' => $role->users])
    </div>

@endsection