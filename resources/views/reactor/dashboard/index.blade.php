@extends('layout.reactor')

@section('pageTitle', trans('general.dashboard'))
@section('contentSubtitle', uppercase(trans('general.home')))

@section('content')

    @include('partials.content.header', [
        'headerTitle' => trans('general.hello') . ', ' . $user->first_name . '!',
        'headerHint' => trans('general.dashboard_hint')
    ])

    <div class="material-light">
        @include('dashboard.tabs', [
            'currentTab' => 'reactor.dashboard',
            'currentKey' => []
        ])

        <div class="content-form content-form-narrower">
            <ul class="content-statistics">
                <li>{{ trans('nodes.total_visits') }}: <strong>{{ $statistics['total_visits'] }}</strong></li>
                <li>{{ trans('nodes.visits_today') }}: <strong>{{ $statistics['visits_today'] }}</strong></li>
                <li>{{ trans('nodes.last_visited') }}: <strong>{{ $statistics['last_visited'] }}</strong></li>
            </ul>

            <div class="statistics-graph">
                <h3>{{ trans('nodes.last_year_stats') }}</h3>
                <p>{{ trans('nodes.last_year_total') }}: <strong>{{ $statistics['last_year_count'] }}</strong></p>
                <canvas height="96" id="last-year-stats"></canvas>
            </div>
        </div>

        <div class="columns-container">
            <div class="column-2">
                <h3>{{ trans('nodes.most_visited') }}</h3>
                @include('nodes.sublist', ['nodes' => $mostVisited])
            </div>
            <div class="column-2">
                <h3>{{ trans('nodes.recently_visited') }}</h3>
                @include('nodes.sublist', ['nodes' => $recentlyVisited])
            </div>
        </div>

        <div class="columns-container">
            <div class="column-2">
                <h3>{{ trans('nodes.recently_edited') }}</h3>
                @include('nodes.sublist', ['nodes' => $recentlyEdited])
            </div>
            <div class="column-2">
                <h3>{{ trans('nodes.recently_created') }}</h3>
                @include('nodes.sublist', ['nodes' => $recentlyCreated])
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    {!! Theme::js('js/chart.js') !!}

    <script>
        var yearData = {
            labels: ["{!! implode('","', $statistics['last_year_labels']) !!}"],
            datasets: [$.extend({
                data: [{!! implode(',', $statistics['last_year_stats']) !!}]
            }, window.chartDisplayDefaults)]
        };

        window.onload = function(){
            var ctx_y = document.getElementById("last-year-stats").getContext("2d");
            window.lineChart_y = new Chart(ctx_y).Line(yearData);
        }
    </script>
@endsection