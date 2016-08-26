@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-blank') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection