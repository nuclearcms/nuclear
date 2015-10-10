@extends('layout.form')

@section('pageTitle', trans('users.edit'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
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
                {!! link_to_route('reactor.users.password', uppercase(trans('users.password')), $profile->getKey(), ['class' => 'content-tab-flap']) !!}
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