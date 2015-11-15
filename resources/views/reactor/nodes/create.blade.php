@extends('layout.form')

@section('pageTitle', trans('nodes.create'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection