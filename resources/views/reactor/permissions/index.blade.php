@extends('layout.content')

@section('pageTitle', trans('users.manage_permissions'))
@section('contentSubtitle', uppercase(trans('users.permissions')))

@section('action')
    <a href="/reactor/permissions/create" class="button button-emphasized button-icon-primary">
        <i class="icon-list-add"></i>
    </a>
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