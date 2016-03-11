@extends('layout.reactor')

@section('pageTitle', trans('nodes.' . $scope . '_nodes'))
@section('contentSubtitle', uppercase(trans('nodes.title')))

@section('content')
    <div class="material-light">
        @include('nodes.translationtabs_index')

        {!! content_table_open(true) !!}
        <th>
            {!! sortable_link('title', uppercase(trans('validation.attributes.title'))) !!}
        </th>
        <th class="content-column-hidden">
            {{ uppercase(trans('validation.attributes.type')) }}
        </th>
        <th>
            {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
        </th>
        {!! content_table_middle() !!}
        @if($nodes->count())
            @include('nodes.content', ['nodes' => $nodes, 'thumbnails' => false])
        @else
            {!! no_results_row('nodes.no_children') !!}
        @endif

        {!! content_table_close(true) !!}
        <div class="content-footer content-footer-sub">
            @include('partials.pagination', ['pagination' => $nodes])
        </div>
    </div>
@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])