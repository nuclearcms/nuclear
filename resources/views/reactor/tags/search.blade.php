@extends('layout.content')

@section('pageTitle', trans('tags.search'))
@section('contentSubtitle')
    {!! link_to_route('reactor.tags.index', uppercase(trans('tags.title'))) !!}
@endsection

@section('content_options')
    @include('partials.content.bigsearch', ['result_count' => $tags->count()])
@endsection

@section('content_sortable_links')
    <th>
        {{ uppercase(trans('validation.attributes.name')) }}
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
    {!! back_to_all_link(route('reactor.tags.index'), 'tags.all_tags') !!}
@endsection

@include('partials.content.delete_modal', ['message' => 'tags.confirm_delete'])