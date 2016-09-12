<div class="chart__info">
    {{ uppercase(trans('general.total_visits') . ': ' . $statistics['total_visits'] . ' . ' .
        trans('general.visits_today') . ': ' . $statistics['visits_today'] . ' . ' .
        trans('general.last_visited') . ': ' . $statistics['last_visited']
    ) }}
</div>