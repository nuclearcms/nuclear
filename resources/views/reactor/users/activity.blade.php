@extends('layout.content')

@section('pageSubtitle', uppercase(trans('users.profile')))

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $user->present()->fullName
    ])
@endsection

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.activity',
        'currentKey' => $user->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('activities.list')
    </div>
@endsection