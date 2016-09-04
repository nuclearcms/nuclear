@extends('mailings.base_index')

@section('pageSubtitle', uppercase(trans('mailings.title')))

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('title', uppercase(trans('validation.attributes.title'))) !!}
    </th>
    <th class="content-list__cell content-list__cell--secondary content-list__cell--head">
        {{ uppercase(trans('validation.attributes.type')) }}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
    </th>
@endsection

@section('content_list')
    @if($mailings->count())
        @include('nodes.list', ['nodes' => $mailings])
    @else
        {!! no_results_row('mailings.no_mailings') !!}
    @endif
@endsection

@section('content_footer')
    @include('partials.contents.pagination', ['paginator' => $mailings])
@endsection