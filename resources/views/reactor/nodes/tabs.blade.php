@extends('partials.contents.tabs')

<?php $flaps = [
    'reactor.nodes.edit' => 'nodes.self',
    'reactor.nodes.parameters.edit' => 'nodes.parameters',
    'reactor.nodes.statistics' => 'general.statistics'
]; ?>

@if($node->hidesChildren())
@section('tabs_prepended')
    <li class="tabs__flap">
        @if($currentRoute === 'children')
            <span class="tabs__link tabs__link--active">{{ uppercase(trans('nodes.children')) }}</span>
        @else
            {!! link_to($node->getDefaultEditUrl(), uppercase(trans('nodes.children')), ['class' => 'tabs__link']) !!}
        @endif
    </li>
@endsection
@endif
