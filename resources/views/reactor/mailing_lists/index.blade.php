@extends('mailing_lists.base_index')

@section('pageSubtitle', uppercase(trans('mailing_lists.title')))

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
    </th>
@endsection

@section('content_list')
    @if($mailing_lists->count())
        @include('mailing_lists.list')
    @else
        {!! no_results_row('mailing_lists.no_mailing_lists') !!}
    @endif
@endsection

@section('content_footer')
    @include('partials.contents.pagination', ['paginator' => $mailing_lists])
@endsection