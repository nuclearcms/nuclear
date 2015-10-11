@extends('layout.content')

@section('pageTitle', trans('users.manage_permissions'))
@section('contentSubtitle', uppercase(trans('users.permissions')))

@can('ACCESS_PERMISSIONS_CREATE')
@section('action')
    {!! action_button(route('reactor.permissions.create'), 'icon-list-add') !!}
@endsection
@endcan

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