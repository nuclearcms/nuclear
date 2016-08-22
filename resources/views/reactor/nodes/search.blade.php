@extends('nodes.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.nodes.index', uppercase(trans('nodes.title'))) !!}
@endsection

@section('actions')
    @parent
    <?php $filterSearch = true; ?>
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
    @if($nodes->count())
        @include('nodes.list')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('nodes') !!}
@endsection