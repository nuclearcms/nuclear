@extends('nodes.base_edit')

@section('children_tabs')
    <ul class="tabs">
        <li class="tabs__flap">
            <span class="tabs__child-link tabs__child-link--active" data-mode="daily">{{ uppercase(trans('general.daily')) }}</span>
        </li>
        <li class="tabs__flap">
            <span class="tabs__child-link" data-mode="weekly">{{ uppercase(trans('general.weekly')) }}</span>
        </li>
        <li class="tabs__flap">
            <span class="tabs__child-link" data-mode="monthly">{{ uppercase(trans('general.monthly')) }}</span>
        </li>
    </ul>
@endsection

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'reactor.nodes.statistics',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner content-inner--plain content-inner--shadow-displaced">
        <div class="content-inner__options content-inner__options--displaced">
            @include('nodes.options')
        </div>

        <div class="chart">
            @include('partials.statistics.information')

        </div>
    </div>
@endsection