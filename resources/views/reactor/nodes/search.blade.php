@extends('layout.content')

@section('pageTitle', trans('nodes.search'))
@section('contentSubtitle')
    {!! link_to_route('reactor.nodes.index', uppercase(trans('nodes.title'))) !!}
@endsection

@section('content_options')
    @include('partials.content.bigsearch', ['result_count' => $nodeTypes->count()])
@endsection

@section('content_sortable_links')
    <th>
        {{ uppercase(trans('validation.attributes.name')) }}
    </th>
    <th>
        {{ uppercase(trans('validation.attributes.label')) }}
    </th>
@endsection

@section('content_list')
    @if($nodeTypes->count())
        @include('nodes.content')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@section('content_footer')
    {!! back_to_all_link(route('reactor.nodes.index'), 'nodes.all') !!}
@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])