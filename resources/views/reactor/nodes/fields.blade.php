@extends('layout.reactor')

@section('pageTitle', trans('nodes.fields'))
@section('contentSubtitle')
    {!! link_to_route('reactor.nodes.index', uppercase(trans('nodes.title'))) !!}
@endsection

@section('action')
    {!! action_button(route('reactor.nodes.field.create', $nodeType->getKey()), 'icon-list-add') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $nodeType->label,
        'headerHint' => $nodeType->name
    ])

    <div class="material-light">
        @include('nodes.tabs', [
            'currentTab' => 'reactor.nodes.fields',
            'currentKey' => $nodeType->getKey()
        ])

        Here is the field sub table
    </div>

@endsection