@extends('layout.content')

@section('pageTitle', trans('users.history'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName
    ])

    <div class="material-light">
        @include('users.tabs', [
            'currentTab' => 'reactor.users.history',
            'currentKey' => $profile->getKey()
        ])

        @include('activities.list')
    </div>
@endsection