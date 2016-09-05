@extends('subscribers.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.subscribers.index', uppercase(trans('subscribers.title'))) !!}
@endsection

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.email')) }}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.created_at')) }}
    </th>
@endsection

@section('content_list')
    @if($subscribers->count())
        @include('subscribers.list')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('subscribers') !!}
@endsection