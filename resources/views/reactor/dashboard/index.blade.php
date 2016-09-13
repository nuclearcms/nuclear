@extends('dashboard.base_index')

@include('partials.statistics.tabs')

@section('content')
    @include('dashboard.tabs', [
        'currentRoute' => 'reactor.dashboard',
        'currentKey' => []
    ])

    <div class="content-inner content-inner--plain content-inner--shadow-displaced">
        @include('partials.statistics.chart')

        <div class="columns">

            @foreach([
                'mostVisited', 'recentlyVisited', 'recentlyEdited', 'recentlyCreated'
            ] as $set)

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