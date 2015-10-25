@extends('layout.content')

@section('pageTitle', trans('nodes.manage'))
@section('contentSubtitle', uppercase(trans('nodes.title')))

@can('ACCESS_NODES_CREATE')
@section('action')
    {!! action_button(route('reactor.nodes.create'), 'icon-plus') !!}
@endsection
@endcan

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('nodes.search')])
@endsection

@section('content_sortable_links')
    <th>
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
    <th>
        {!! sortable_link('label', uppercase(trans('validation.attributes.label'))) !!}
    </th>
@endsection

@section('content_list')
    @include('nodes.content')
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $nodeTypes])
@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])