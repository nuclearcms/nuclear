@extends('mailings.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.mailings.index', uppercase(trans('mailings.title'))) !!}
@endsection

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.title')) }}
    </th>
    <th class="content-list__cell content-list__cell--secondary content-list__cell--head">
        {{ uppercase(trans('validation.attributes.type')) }}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.created_at')) }}
    </th>
@endsection

@section('content_list')
    @if($mailings->count())
        @include('nodes.list', ['nodes' => $mailings])
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('mailings') !!}
@endsection