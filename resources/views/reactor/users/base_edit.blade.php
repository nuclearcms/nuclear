@extends('layout.' . ((isset($_withForm) && $_withForm === false) ? 'content' : 'form'))

@section('pageSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $user->present()->fullName
    ])
@endsection

@section('content')
    @include('partials.contents.form')
@endsection