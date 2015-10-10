@extends('layout.form')

@section('pageTitle', trans('users.edit_role'))
@section('contentSubtitle')
    <a href="/reactor/roles">
        {{ uppercase(trans('users.roles')) }}
    </a>
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
        <ul class="content-tabs-bar">
            <li>
                <span class="content-tab-flap active">{{ uppercase(trans('users.role')) }}</span>
            </li><li>
                <a href="/reactor/roles/{{ $role->getKey() }}/permissions" class="content-tab-flap">{{ uppercase(trans('users.permissions')) }}</a>
            </li><li>
                <a href="/reactor/roles/{{ $role->getKey() }}/users" class="content-tab-flap">{{ uppercase(trans('users.title')) }}</a>
            </li>
        </ul>
        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection