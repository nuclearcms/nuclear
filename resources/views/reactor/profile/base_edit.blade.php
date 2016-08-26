@extends('layout.form')

@section('pageSubtitle', uppercase(trans('users.profile')))

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $profile->present()->fullName
    ])
@endsection

@section('content')
    @include('partials.contents.form')
@endsection