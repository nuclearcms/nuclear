@extends('layout.reactor')

@section('pageTitle', trans('nodes.tree'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    {!! action_button(route('reactor.contents.create', $node->getKey()), 'icon-plus') !!}
@endsection

@section('content')
    @include('partials.nodes.ancestors', [
        'ancestors' => $node->getAncestors()
    ])

    @include('partials.content.header', [
        'headerTitle' => $node->title,
        'headerHint' => $node->nodeType->label
    ])

    <div class="material-light">
        @include('nodes.tabs', [
            'currentTab' => 'reactor.contents.tree',
            'currentKey' => $node->getKey()
        ])

        @include('nodes.subtree', [
            'nodes' => $node->getPositionOrderedChildren(),
        ])
    </div>

@endsection