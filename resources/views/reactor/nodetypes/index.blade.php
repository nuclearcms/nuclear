@extends('nodetypes.base_index')

@section('pageSubtitle', uppercase(trans('nodetypes.title')))

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('label', uppercase(trans('validation.attributes.label'))) !!}
    </th>
@endsection

@section('content_list')
    @include('nodetypes.list')
@endsection

@section('content_footer')
    @include('partials.contents.pagination', ['paginator' => $nodetypes])
@endsection