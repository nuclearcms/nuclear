@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.mailings.index', uppercase(trans('mailings.title'))) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection