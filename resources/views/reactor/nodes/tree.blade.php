@extends('layout.reactor')

@section('pageTitle', trans('nodes.tree'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    {!! action_button(route('reactor.contents.create', $node->getKey()), 'icon-plus') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $node->title,
        'headerHint' => $node->nodeType->label
    ])

    <div class="material-light">
        @include('nodes.tabs', [
            'currentTab' => 'reactor.contents.tree',
            'currentKey' => $node->getKey()
        ])

        WE HAVE THE TREE HERE SORTABLE SHIZ
    </div>

@endsection