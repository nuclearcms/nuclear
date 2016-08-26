@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.tags.index', uppercase(trans('tags.title'))) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-tag-create') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection