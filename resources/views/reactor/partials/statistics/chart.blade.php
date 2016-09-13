<div class="chart" id="chartTabs">

    <div class="chart__info">
        {{ uppercase(trans('general.total_visits') . ': ' . $statistics['total_visits'] . ' . ' .
            trans('general.visits_today') . ': ' . $statistics['visits_today'] . ' . ' .
            trans('general.last_visited') . ': ' . $statistics['last_visited']
        ) }}
    </div>

    <div class="chart__container chart__container--active chart__container--daily">
        <canvas height="88" id="weekStatisticsGraph"></canvas>
    </div>

    <div class="chart__container chart__container--weekly">
        <canvas height="88" id="monthStatisticsGraph"></canvas>
    </div>

    <div class="chart__container chart__container--monthly">
        <canvas height="88" id="yearStatisticsGraph"></canvas>
    </div>

</div>

@section('scripts')
    @parent

    {!! Theme::js('js/charts.js') !!}

    <script>
        @foreach(['year', 'month', 'week'] as $span)
        var {{ $span }}Options = {
            type: 'line',
            data: {
                labels: {!! json_encode($statistics['chart']['labels']['last_' . $span . '_labels']) !!},
                datasets: [
                    @foreach($statistics['chart']['statistics'] as $locale => $data)
                    $.extend({label: '{{ uppercase($locale) }}', data: {!! json_encode($data['last_' . $span . '_stats']) !!}}, window.chartDisplayDefaults),
                    @endforeach
                ]
            },
            options: {scales: {yAxes: [{gridLines: {color: 'transparent'}}]}}
        };
        @endforeach

        window.onload = function () {
            @foreach(['year', 'month', 'week'] as $span)
            var {{ $span }}Ctx = document.getElementById("{{ $span }}StatisticsGraph").getContext("2d");
            new Chart({{ $span }}Ctx, {{ $span }}Options);
            @endforeach
        }
    </script>
@endsection