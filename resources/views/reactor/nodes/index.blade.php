@extends('nodes.base_index')

@section('pageSubtitle', uppercase(trans('nodes.title')))

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
    @if($nodes->count())
        @include('nodes.list')
    @else
        {!! no_results_row('nodes.no_nodes') !!}
    @endif
@endsection

@section('content_footer')
    @include('partials.contents.pagination', ['paginator' => $nodes])
@endsection