@extends('mailing_lists.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.mailing_lists.index', uppercase(trans('mailing_lists.title'))) !!}
@endsection

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.created_at')) }}
    </th>
@endsection

@section('content_list')
    @if($mailing_lists->count())
        @include('mailing_lists.list')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('mailing_lists') !!}
@endsection