@extends('layout.form')

@section('pageTitle', trans('users.change_password'))
@section('contentSubtitle', uppercase(trans('users.profile')))

@section('action')
    {!! submit_button('icon-lock') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName
    ])

    <div class="material-light">
        @include('profile.tabs', [
            'currentTab' => 'reactor.profile.password',
            'currentKey' => []
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection