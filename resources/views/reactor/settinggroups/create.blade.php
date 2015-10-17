@extends('layout.form')

@section('pageTitle', trans('settings.create_group'))
@section('contentSubtitle')
    {!! link_to_route('reactor.settinggroups.index', uppercase(trans('settings.groups_title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection