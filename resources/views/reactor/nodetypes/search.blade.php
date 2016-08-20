@extends('nodetypes.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.nodetypes.index', uppercase(trans('nodetypes.title'))) !!}
@endsection

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.label')) }}
    </th>
@endsection

@section('content_list')
    @if($nodetypes->count())
        @include('nodetypes.list')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('nodetypes') !!}
@endsection