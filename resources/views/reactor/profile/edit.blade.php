@extends('layout.form')

@section('pageTitle', trans('auth.edit_profile'))
@section('contentSubtitle', uppercase(trans('users.profile')))

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName
    ])

    <div class="material-light">
        @include('profile.tabs', [
            'currentTab' => 'reactor.profile.edit',
            'currentKey' => $profile->getKey()
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection