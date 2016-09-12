@extends('layout.reactor')

@section('pageSubtitle', uppercase(trans('general.home')))

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => trans('general.hello') . ', ' . $currentUser->first_name . '!',
        'headerHint' => trans('general.dashboard_hint')
    ])
@endsection