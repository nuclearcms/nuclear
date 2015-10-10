@extends('layout.content')

@section('pageTitle', trans('users.manage'))
@section('contentSubtitle', uppercase(trans('users.title')))

@section('action')
    {!! action_button('/reactor/users/create', 'icon-user-add') !!}
@endsection

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('users.search')])
@endsection

@section('content_sortable_links')
    <th>
        {!! sortable_link('first_name', uppercase(trans('users.name'))) !!}
    </th>
    <th class="content-column-hidden">
        {!! sortable_link('email', uppercase(trans('validation.attributes.email'))) !!}
    </th>
    <th class="content-column-hidden">
        {!! sortable_link('created_at', uppercase(trans('users.joined_at'))) !!}
    </th>
@endsection

@section('content_list')
    @include('users.content')
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $users])
@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_delete'])