@extends('permissions.base_index')

@section('pageSubtitle', uppercase(trans('permissions.title')))

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
@endsection

@section('content_list')
    @include('permissions.content')
@endsection

@section('content_footer')
    @include('partials.contents.pagination', ['paginator' => $permissions])
@endsection