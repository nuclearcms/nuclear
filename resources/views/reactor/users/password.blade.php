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
        @include('users.tabs', [
            'currentTab' => 'reactor.users.password',
            'currentKey' => $profile->getKey()
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection