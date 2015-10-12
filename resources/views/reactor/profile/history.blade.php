@extends('layout.content')

@section('pageTitle', trans('users.history'))
@section('contentSubtitle', uppercase(trans('users.profile')))

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName
    ])

    <div class="material-light">
        @include('profile.tabs', [
            'currentTab' => 'reactor.profile.history',
            'currentKey' => []
        ])

        @include('activities.list')
    </div>
@endsection