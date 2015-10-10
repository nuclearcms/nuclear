@extends('layout.content')

@section('pageTitle', trans('users.manage_permissions'))
@section('contentSubtitle', uppercase(trans('users.permissions')))

@section('action')
    {!! action_button('/reactor/permissions/create', 'icon-list-add') !!}
@endsection

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('users.search_permissions')])
@endsection

@section('content_sortable_links')
    <th>
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
@endsection

@section('content_list')
    @include('permissions.content')
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $permissions])
@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_delete_permission'])