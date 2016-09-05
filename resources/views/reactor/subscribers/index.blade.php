@extends('subscribers.base_index')

@section('pageSubtitle', uppercase(trans('subscribers.title')))

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('email', uppercase(trans('validation.attributes.email'))) !!}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
    </th>
@endsection

@section('content_list')
    @if($subscribers->count())
        @include('subscribers.list')
    @else
        {!! no_results_row('subscribers.no_subscribers') !!}
    @endif
@endsection

@section('content_footer')
    @include('partials.contents.pagination', ['paginator' => $subscribers])
@endsection