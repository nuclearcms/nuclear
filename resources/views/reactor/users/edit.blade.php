@extends('layout.form')

@section('pageTitle', trans('users.edit'))
@section('contentSubtitle')
    <a href="/reactor/users">
        {{ uppercase(trans('users.title')) }}
    </a>
@endsection

@section('action')
    <button class="button button-emphasized button-icon-primary" type="submit">
        <i class="icon-floppy"></i>
    </button>
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName
    ])

    <div class="material-light">
        <ul class="content-tabs-bar">
            <li>
                <span class="content-tab-flap active">{{ uppercase(trans('users.profile')) }}</span>
            </li><li>
                <a href="/reactor/users/{{ $profile->getKey() }}/password" class="content-tab-flap">{{ uppercase(trans('users.password')) }}</a>
            </li><li>
                <a href="/reactor/users/{{ $profile->getKey() }}/permissions" class="content-tab-flap">{{ uppercase(trans('users.permissions')) }}</a>
            </li><li>
                <a href="/reactor/users/{{ $profile->getKey() }}/roles" class="content-tab-flap">{{ uppercase(trans('users.roles')) }}</a>
            </li><li>
                <a href="/reactor/users/{{ $profile->getKey() }}/history" class="content-tab-flap">{{ uppercase(trans('users.history')) }}</a>
            </li>
        </ul>
        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection