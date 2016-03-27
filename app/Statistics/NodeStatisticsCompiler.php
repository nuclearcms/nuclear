<?php

namespace Reactor\Statistics;


use Carbon\Carbon;
use Reactor\Nodes\Node;

class NodeStatisticsCompiler extends Compiler {

    /**
     * Collects node statistics
     *
     * @param Node $node
     * @param string $locale
     * @return array
     */
    public function collectNodeStatistics(Node $node, $locale)
    {
        $cruncher = $this->getCruncher();

        $last_visited = $cruncher->getLastVisited($locale, $node->trackerViews());
        $last_visited = $last_visited ? $last_visited->diffForHumans() : trans('general.never');

        $total_visits = $cruncher->getTotalVisitCount($locale, $node->trackerViews());

        $visits_today = $cruncher->getTodayCount($locale, $node->trackerViews());

        $last_year_count = $cruncher->getRelativeYearCount(null, $locale, $node->trackerViews());
        $last_month_count = $cruncher->getRelativeMonthCount(null, $locale, $node->trackerViews());
        $last_week_count = $cruncher->getRelativeWeekCount(null, $locale, $node->trackerViews());

        $compilation = compact(
            'last_visited', 'total_visits', 'visits_today',
            'last_year_count', 'last_month_count', 'last_week_count'
        );

        return $this->mergeNodeTableStatistics($cruncher, $node, $locale, $compilation);
    }

    /**
     * @param Cruncher $cruncher
     * @param $node
     * @param $locale
     * @param array $compilation
     * @return array
     */
    protected function mergeNodeTableStatistics($cruncher, $node, $locale, $compilation)
    {
        list($last_year_stats, $last_year_labels) = $cruncher
            ->getCountPerMonth(Carbon::today()->subYear(), null, $locale, $node->trackerViews());
        $compilation = $this->compileYearStatistics($last_year_stats, $last_year_labels, $compilation);

        list($last_month_stats, $last_month_labels) = $cruncher
            ->getCountPerWeek(Carbon::today()->subMonth(), null, $locale, $node->trackerViews());
        $compilation = $this->compileMonthStatistics($last_month_stats, $last_month_labels, $compilation);

        list($last_week_stats, $last_week_labels) = $cruncher
            ->getCountPerDay(Carbon::today()->subWeek(), null, $locale, $node->trackerViews());
        $compilation = $this->compileWeekStatistics($last_week_stats, $last_week_labels, $compilation);

        return $compilation;
    }

}