@extends('layout.form')

@section('pageTitle', trans('settings.modify'))
@section('contentSubtitle')
    {!! link_to_route('reactor.settings.index', uppercase(trans('settings.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-cog') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => is_null($group) ? trans('settings.all') :
            ((trans()->has('settings.group_' . $group)) ? trans('settings.group_' . $group) : settings()->getGroup($group))
    ])

    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>

@endsection