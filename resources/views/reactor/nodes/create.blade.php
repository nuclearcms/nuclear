@extends('layout.form')

@section('pageTitle', trans('nodes.create'))
@section('contentSubtitle')
    {!! link_to_route('reactor.nodes.index', uppercase(trans('nodes.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection