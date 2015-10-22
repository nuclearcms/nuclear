@extends('layout.form')

@section('pageTitle', trans('documents.embed'))
@section('contentSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-code') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection