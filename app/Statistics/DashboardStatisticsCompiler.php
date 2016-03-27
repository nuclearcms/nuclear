<?php

namespace Reactor\Statistics;


use Carbon\Carbon;
use Kenarkose\Tracker\Cruncher;

class DashboardStatisticsCompiler extends Compiler {

    /**
     * Collects dashboard statistics
     *
     * @return array
     */
    public function collectDashboardStatistics()
    {
        $cruncher = $this->getCruncher();

        $last_visited = $cruncher->getLastVisited();
        $last_visited = $last_visited ? $last_visited->diffForHumans() : trans('general.never');

        $total_visits = $cruncher->getTotalVisitCount();

        $visits_today = $cruncher->getTodayCount();

        $last_year_count = $cruncher->getRelativeYearCount();

        $compilation = compact(
            'last_visited', 'total_visits',
            'visits_today', 'last_year_count'
        );

        return $this->mergeDashboardTableStatistics($cruncher, $compilation);
    }

    /**
     * @param Cruncher $cruncher
     * @param array $compilation
     * @return array
     */
    protected function mergeDashboardTableStatistics($cruncher, $compilation)
    {
        list($stats, $labels) = $cruncher
            ->getCountPerMonth(Carbon::today()->subYear());

        return $this->compileYearStatistics($stats, $labels, $compilation);
    }

}