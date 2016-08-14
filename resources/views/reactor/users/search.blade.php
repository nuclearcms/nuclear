@extends('users.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
    <th class="content-list__cell content-list__cell--head content-list__cell--secondary">
        {{ uppercase(trans('validation.attributes.email')) }}
    </th>
    <th class="content-list__cell content-list__cell--head content-list__cell--secondary">
        {{ uppercase(trans('users.joined_at')) }}
    </th>
@endsection

@section('content_list')
    @if($users->count())
        @include('users.list')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('users') !!}
@endsection