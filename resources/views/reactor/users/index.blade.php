@extends('layout.content')

@section('pageTitle', trans('users.manage'))
@section('contentSubtitle', uppercase(trans('users.title')))

@section('action')
    <a href="/reactor/users/create" class="button button-emphasized button-icon-primary">
        <i class="icon-user-add"></i>
    </a>
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
        {!! uppercase(trans('users.group')) !!}
    </th>
@endsection

@section('content_list')
    @include('users.content')
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $users])
@endsection