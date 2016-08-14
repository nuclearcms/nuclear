@extends('layout.content')

@section('pageSubtitle', uppercase(trans('users.profile')))

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $profile->present()->fullName
    ])
@endsection

@section('content')
    @include('profile.tabs', [
        'currentRoute' => 'reactor.profile.history',
        'currentKey' => []
    ])

    <div class="content-inner content-inner--compact">
    @include('activities.list')
    </div>
@endsection