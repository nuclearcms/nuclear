@extends('layout.content')

@section('pageTitle', trans('settings.manage'))
@section('contentSubtitle', uppercase(trans('settings.title')))

@can('ACCESS_SETTINGS_CREATE')
@section('action')
    {!! action_button(route('reactor.settings.create'), 'icon-list-add') !!}
@endsection
@endcan

@section('content_sortable_links')
    <th>
        {!! uppercase(trans('validation.attributes.label')) !!}
    </th>
    <th>
        {!! uppercase(trans('validation.attributes.name')) !!}
    </th>
@endsection

@section('content_list')
    @include('settings.content')
@endsection

@include('partials.content.delete_modal', ['message' => 'settings.confirm_delete'])