@extends('layout.content')

@section('pageTitle', trans('users.search'))
@section('contentSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
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
    {!! back_to_all_link(route('reactor.users.index'), 'users.all') !!}
@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_delete'])