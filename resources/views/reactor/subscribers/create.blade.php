@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.subscribers.index', uppercase(trans('subscribers.title'))) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection