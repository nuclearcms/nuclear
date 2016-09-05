@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.mailing_lists.index', uppercase(trans('mailing_lists.title'))) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection