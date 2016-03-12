@extends('layout.content')

@section('pageTitle', trans('tags.manage'))
@section('contentSubtitle', uppercase(trans('tags.title')))

@can('ACCESS_TAGS_WRITE')
@section('action')
    {!! action_button(route('reactor.tags.create'), 'icon-plus') !!}
@endsection
@endcan

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('tags.search')])
@endsection

@section('content_sortable_links')
    <th>
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
    <th class="content-column-hidden">
        {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
    </th>
@endsection

@section('content_list')
    @if($tags->count())
        @include('tags.content')
    @else
        {!! no_results_row('tags.no_tags') !!}
    @endif
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $tags])
@endsection

@include('partials.content.delete_modal', ['message' => 'tags.confirm_delete'])