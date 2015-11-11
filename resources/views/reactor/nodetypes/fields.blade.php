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
        @include('nodetypes.tabs', [
            'currentTab' => 'reactor.nodes.fields',
            'currentKey' => $nodeType->getKey()
        ])

        @include('nodefields.subtable', ['fields' => $nodeType->getFields()])

    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete_field'])