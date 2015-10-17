@extends('layout.form')

@section('pageTitle', trans('settings.edit'))
@section('contentSubtitle')
    {!! link_to_route('reactor.settings.index', uppercase(trans('settings.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $setting['key']
    ])

    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>

@endsection