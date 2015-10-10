@extends('layout.content')

@section('pageTitle', trans('users.search_permissions'))
@section('contentSubtitle')
    <a href="/reactor/permissions">
        {{ uppercase(trans('users.permissions')) }}
    </a>
@endsection

@section('content_options')
    @include('partials.content.bigsearch', ['result_count' => $permissions->count()])
@endsection

@section('content_sortable_links')
    <th>
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
@endsection

@section('content_list')
    @if($permissions->count())
        @include('permissions.content')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('/reactor/permissions', 'users.all_permissions') !!}
@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_delete_permission'])