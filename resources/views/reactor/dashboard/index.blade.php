@extends('layout.reactor')

@section('pageTitle', trans('general.dashboard'))
@section('contentSubtitle', uppercase(trans('general.home')))

@section('content')

    @include('partials.content.header', [
        'headerTitle' => trans('general.hello') . ', ' . $user->first_name . '!',
        'headerHint' => trans('general.dashboard_hint')
    ])

    <div class="material-light">
        @include('dashboard.tabs', [
            'currentTab' => 'reactor.dashboard',
            'currentKey' => []
        ])

        METRICS HERE
    </div>

@endsection