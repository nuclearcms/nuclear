@extends('layout.form')

@section('pageTitle', trans('users.edit_role'))
@section('contentSubtitle')
    {!! link_to_route('reactor.roles.index', uppercase(trans('users.roles'))) !!}
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
                {!! link_to_route('reactor.roles.permissions', uppercase(trans('users.permissions')), $role->getKey(), ['class' => 'content-tab-flap']) !!}
            </li><li>
                {!! link_to_route('reactor.roles.users', uppercase(trans('users.title')), $role->getKey(), ['class' => 'content-tab-flap']) !!}
            </li>
        </ul>
        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection