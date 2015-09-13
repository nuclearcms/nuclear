@extends('layout.reactor')

@section('pageTitle', trans('general.dashboard'))
@section('contentSubtitle', uppercase(trans('general.home')))

@section('content')
    <div class="content-header">
        <h4>{{ trans('general.hello') . ', ' . $user->first_name . '!' }}</h4>
        <p>{{ trans('general.dashboard_hint') }}</p>
    </div>

    <div class="content-main material-light">
        MAIN CONTENT HERE
    </div>

@endsection