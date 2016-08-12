@extends('permissions.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.permissions.index', uppercase(trans('permissions.title'))) !!}
@endsection

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
@endsection

@section('content_list')
    @if($permissions->count())
        @include('permissions.list')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link('permissions') !!}
@endsection