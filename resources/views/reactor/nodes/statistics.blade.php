@extends('layout.reactor')

@section('pageTitle', trans('nodes.statistics'))
@section('contentSubtitle', uppercase(trans('nodes.title')))

@section('content')
    @include('partials.nodes.ancestors', [
        'ancestors' => $node->getAncestors()
    ])

    @include('partials.content.header', [
        'headerTitle' => $source->title,
        'headerHint' => $node->nodeType->label
    ])

    <div class="material-light">
        @include('nodes.tabs', [
            'currentTab' => 'reactor.contents.statistics',
            'currentKey' => $node->getKey()
        ])

        @include('nodes.translationtabs', [
            'route' => 'reactor.contents.statistics'
        ])

        <div class="content-form content-form-narrower">
            <ul class="content-statistics">
                <li>{{ trans('nodes.total_visits') }}: <strong>{{ $statistics['total_visits'] }}</strong></li>
                <li>{{ trans('nodes.visits_today') }}: <strong>{{ $statistics['visits_today'] }}</strong></li>
                <li>{{ trans('nodes.last_visited') }}: <strong>{{ $statistics['last_visited'] }}</strong></li>
            </ul>

            <div class="statistics-graph">
                <h3>{{ trans('nodes.last_week_stats') }}</h3>
                <p>{{ trans('nodes.last_week_total') }}: <strong>{{ $statistics['last_week_count'] }}</strong></p>
                <canvas height="96" id="last-week-stats"></canvas>
            </div>

            <div class="statistics-graph">
                <h3>{{ trans('nodes.last_month_stats') }}</h3>
                <p>{{ trans('nodes.last_month_total') }}: <strong>{{ $statistics['last_month_count'] }}</strong></p>
                <canvas height="96" id="last-month-stats"></canvas>
            </div>

            <div class="statistics-graph">
                <h3>{{ trans('nodes.last_year_stats') }}</h3>
                <p>{{ trans('nodes.last_year_total') }}: <strong>{{ $statistics['last_year_count'] }}</strong></p>
                <canvas height="96" id="last-year-stats"></canvas>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    {!! Theme::js('js/chart.js') !!}

    <script>
        var weekData = {
            labels: ["{!! implode('","', $statistics['last_week_labels']) !!}"],
            datasets: [$.extend({
                data: [{!! implode(',', $statistics['last_week_stats']) !!}]
            }, window.chartDisplayDefaults)]
        };

        var monthData = {
            labels: ["{!! implode('","', $statistics['last_month_labels']) !!}"],
            datasets: [$.extend({
                data: [{!! implode(',', $statistics['last_month_stats']) !!}]
            }, window.chartDisplayDefaults)]
        };

        var yearData = {
            labels: ["{!! implode('","', $statistics['last_year_labels']) !!}"],
            datasets: [$.extend({
                data: [{!! implode(',', $statistics['last_year_stats']) !!}]
            }, window.chartDisplayDefaults)]
        };

        window.onload = function(){
            var ctx_w = document.getElementById("last-week-stats").getContext("2d"),
                ctx_m = document.getElementById("last-month-stats").getContext("2d"),
                ctx_y = document.getElementById("last-year-stats").getContext("2d");

            window.lineChart_w = new Chart(ctx_w).Line(weekData);
            window.lineChart_m = new Chart(ctx_m).Line(monthData);
            window.lineChart_y = new Chart(ctx_y).Line(yearData);
        }
    </script>
@endsection