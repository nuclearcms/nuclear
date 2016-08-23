@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'nodes'])

    @include('partials.contents.filter', [
        'filterTypes' => ['all', 'published', 'withheld', 'draft', 'pending', 'archived', 'invisible', 'locked'],
        'defaultFilter' => 'all',
        'key' => 'nodes',
        'filterSearch' => isset($filterSearch) ? $filterSearch : false
    ])

    @include('partials.contents.bulk', ['key' => 'nodes'])

    @can('EDIT_NODES')
        {!! header_action_open('nodes.new', 'header__action--right') !!}
        {!! action_button(route('reactor.nodes.create'), 'icon-plus') !!}
        {!! header_action_close() !!}
    @endcan
@endsection