@extends('layout.content')

@section('pageTitle', trans('settings.manage_groups'))
@section('contentSubtitle', uppercase(trans('settings.groups_title')))

@can('ACCESS_SETTINGS_CREATE')
@section('action')
    {!! action_button(route('reactor.settinggroups.create'), 'icon-plus') !!}
@endsection
@endcan

@section('content_sortable_links')
    <th>
        {!! uppercase(trans('validation.attributes.name')) !!}
    </th>
@endsection

@section('content_list')
    @include('settinggroups.content')
@endsection

@include('partials.content.delete_modal', ['message' => 'settings.confirm_delete_group'])