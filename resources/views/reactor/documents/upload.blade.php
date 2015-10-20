@extends('layout.REACTOR')

@section('pageTitle', trans('documents.upload'))
@section('contentSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('content')

    @include('documents.dropzone')

@endsection

@section('scripts')
    {!! Theme::js('js/form.js') !!}
@endsection