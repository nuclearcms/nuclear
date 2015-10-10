@extends('layout.form')

@section('pageTitle', trans('users.edit'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $profile->present()->fullName
    ])

    <div class="material-light">
        @include('users.tabs', [
            'currentTab' => 'reactor.users.edit',
            'currentKey' => $profile->getKey()
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection