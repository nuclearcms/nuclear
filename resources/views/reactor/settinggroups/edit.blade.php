@extends('layout.form')

@section('pageTitle', trans('settings.edit_group'))
@section('contentSubtitle')
    {!! link_to_route('reactor.settinggroups.index', uppercase(trans('settings.groups_title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $name
    ])

    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>

@endsection