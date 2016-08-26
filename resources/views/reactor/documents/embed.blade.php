@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-document-embed') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection