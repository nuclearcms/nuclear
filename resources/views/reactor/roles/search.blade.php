@extends('layout.content')

@section('pageTitle', trans('users.search_roles'))
@section('contentSubtitle')
    <a href="/reactor/roles">
        {{ uppercase(trans('users.roles')) }}
    </a>
@endsection

@section('content_options')
    @include('partials.content.bigsearch', ['result_count' => $roles->count()])
@endsection

@section('content_sortable_links')
    <th>
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
@endsection

@section('content_list')
    @if($roles->count())
        @include('roles.content')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    <a class="button back-link" href="/reactor/roles">
        <i class="icon-left-thin"></i>{{ trans('users.all_roles') }}
    </a>
@endsection