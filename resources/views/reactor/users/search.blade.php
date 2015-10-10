@extends('layout.content')

@section('pageTitle', trans('users.search'))
@section('contentSubtitle')
    <a href="/reactor/users">
        {{ uppercase(trans('users.title')) }}
    </a>
@endsection

@section('content_options')
    @include('partials.content.bigsearch', ['result_count' => $users->count()])
@endsection

@section('content_sortable_links')
    <th>
        {{ uppercase(trans('users.name')) }}
    </th>
    <th class="content-column-hidden">
        {{ uppercase(trans('validation.attributes.email')) }}
    </th>
    <th class="content-column-hidden">
        {{ uppercase(trans('users.joined_at')) }}
    </th>
@endsection

@section('content_list')
    @if($users->count())
        @include('users.content')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    <a class="button back-link" href="/reactor/users">
        <i class="icon-left-thin"></i>{{ trans('users.all') }}
    </a>
@endsection