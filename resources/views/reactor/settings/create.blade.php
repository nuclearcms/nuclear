@extends('layout.form')

@section('pageTitle', trans('settings.create'))
@section('contentSubtitle')
    {!! link_to_route('reactor.settings.index', uppercase(trans('settings.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-list-add') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection