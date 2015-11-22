@extends('layout.content')

@section('pageTitle', trans('nodes.search'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('content_options')
    @include('partials.content.bigsearch', ['result_count' => $nodes->count()])
@endsection

@section('content_sortable_links')
    <th>
        {{ uppercase(trans('validation.attributes.title')) }}
    </th>
    <th>
        {{ uppercase(trans('validation.attributes.type')) }}
    </th>
@endsection

@section('content_list')
    @if($nodes->count())
        @include('nodes.content')
    @else
        {!! no_results_row() !!}
    @endif
@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])