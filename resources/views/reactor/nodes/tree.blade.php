@extends('layout.reactor')

@section('pageTitle', trans('nodes.tree'))
@section('contentSubtitle', uppercase(trans('nodes.title')))

@section('action')
    {!! action_button(route('reactor.contents.create', $node->getKey()), 'icon-plus') !!}
@endsection

@section('content')
    @include('partials.nodes.ancestors', [
        'ancestors' => $node->getAncestors()
    ])

    @include('partials.content.header', [
        'headerTitle' => $source->title,
        'headerHint' => $node->getNodeType()->label
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