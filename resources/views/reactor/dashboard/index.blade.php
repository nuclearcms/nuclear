@extends('dashboard.base_index')

@if(tracker()->saveEnabled())
@include('partials.statistics.tabs')
@endif

@section('content')
    @include('dashboard.tabs', [
        'currentRoute' => 'reactor.dashboard',
        'currentKey' => []
    ])
    <div class="content-inner content-inner--plain content-inner--shadow-displaced">
        @if(tracker()->saveEnabled())
        @include('partials.statistics.chart')
        @endif

        <div class="columns">
            <?php $columns = tracker()->saveEnabled() ?
                ['mostVisited', 'recentlyVisited', 'recentlyEdited', 'recentlyCreated'] :
                ['recentlyEdited', 'recentlyCreated'];
            ?>

            @foreach($columns as $set)
            <div class="column">
                <div class="column__heading">{{ uppercase(trans('nodes.' . snake_case($set))) }}</div>

                <ul class="column-list">
                    @foreach(${$set} as $node)
                    <li>
                        <a class="column-list__item" href="{{ $node->getDefaultEditUrl() }}">
                            {{ $node->getTitle() }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach

        </div>
    </div>
@endsection