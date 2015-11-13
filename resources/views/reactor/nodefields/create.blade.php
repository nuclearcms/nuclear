@extends('layout.form')

@section('pageTitle', trans('nodes.create_field'))
@section('contentSubtitle')
    {!! link_to_route('reactor.nodes.fields', uppercase($nodeType->label), ['id' => $nodeType->getKey()]) !!}
@endsection

@section('action')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection