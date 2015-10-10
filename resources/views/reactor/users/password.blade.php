@extends('layout.form')

@section('pageTitle', trans('users.change_password'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-lock') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName,
        'headerHint' => $profile->present()->userGroup
    ])

    <div class="material-light">
        <ul class="content-tabs-bar">
            <li>
                {!! link_to_route('reactor.users.edit', uppercase(trans('users.profile')), $profile->getKey(), ['class' => 'content-tab-flap']) !!}
            </li><li>
                <span class="content-tab-flap active">{{ uppercase(trans('users.password')) }}</span>
            </li><li>
                {!! link_to_route('reactor.users.permissions', uppercase(trans('users.permissions')), $profile->getKey(), ['class' => 'content-tab-flap']) !!}
            </li><li>
                {!! link_to_route('reactor.users.roles', uppercase(trans('users.roles')), $profile->getKey(), ['class' => 'content-tab-flap']) !!}
            </li><li>
                {!! link_to_route('reactor.users.history', uppercase(trans('users.history')), $profile->getKey(), ['class' => 'content-tab-flap']) !!}
            </li>
        </ul>
        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection