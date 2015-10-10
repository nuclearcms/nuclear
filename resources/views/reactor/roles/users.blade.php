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
        <ul class="content-tabs-bar">
            <li>
                {!! link_to_route('reactor.roles.edit', uppercase(trans('users.role')), $role->getKey(), ['class' => 'content-tab-flap']) !!}
            </li><li>
                {!! link_to_route('reactor.roles.permissions', uppercase(trans('users.permissions')), $role->getKey(), ['class' => 'content-tab-flap']) !!}
            </li><li>
                <span class="content-tab-flap active">{{ uppercase(trans('users.title')) }}</span>
            </li>
        </ul>
        @include('users.subtable', ['users' => $role->users])
    </div>

@endsection