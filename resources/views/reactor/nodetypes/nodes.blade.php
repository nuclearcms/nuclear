@extends('layout.reactor')

@section('pageTitle', trans('nodes.title'))
@section('contentSubtitle')
    {!! link_to_route('reactor.nodes.index', uppercase(trans('nodes.title_type'))) !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $nodeType->label,
        'headerHint' => $nodeType->name
    ])

    <div class="material-light">
        @include('nodetypes.tabs', [
            'currentTab' => 'reactor.nodes.nodes',
            'currentKey' => $nodeType->getKey()
        ])

        @include('nodes.subtable')
    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])