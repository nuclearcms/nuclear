<?php

namespace Reactor\Statistics;


use Carbon\Carbon;
use Kenarkose\Tracker\Cruncher;
use Nuclear\Hierarchy\Node;

class NodeStatisticsCompiler extends StatisticsCompiler {

    /**
     * Collects node statistics
     *
     * @param Node $node
     * @return array
     */
    public function compileStatistics(Node $node)
    {
        $cruncher = $this->getCruncher();

        $compilation = $this->compileBaseStatistics($node, $cruncher);

        return $this->compileTableStatistics($cruncher, $node, $compilation);
    }

    /**
     * @param Node $node
     * @param Cruncher $cruncher
     * @return array
     */
    protected function compileBaseStatistics(Node $node, Cruncher $cruncher)
    {
        $last_visited = $cruncher->getLastVisited(null, $node->trackerViews());
        $last_visited = $last_visited ? $last_visited->diffForHumans() : trans('general.never');

        $total_visits = $cruncher->getTotalVisitCount(null, $node->trackerViews());

        $visits_today = $cruncher->getTodayCount(null, $node->trackerViews());

        return compact('last_visited', 'total_visits', 'visits_today');
    }

    /**
     * @param Cruncher $cruncher
     * @param Node $node
     * @param array $compilation
     * @return array
     */
    protected function compileTableStatistics(Cruncher $cruncher, Node $node, array $compilation)
    {
        $cacheKey = 'node_' . $node->getKey();

        foreach($node->translations as $translation)
        {
            $compilation = $this->compileTableLocaleStatistics($cruncher, $node, $translation->locale, $cacheKey, $compilation);
        }

        return $compilation;
    }

    /**
     * @param Cruncher $cruncher
     * @param Node $node
     * @param string $locale
     * @param string $cacheKey
     * @param array $compilation
     * @return array
     */
    protected function compileTableLocaleStatistics(Cruncher $cruncher, Node $node, $locale, $cacheKey, array $compilation)
    {
        list($last_year_stats, $last_year_labels) = $cruncher
            ->getCountPerMonth(Carbon::today()->subYear(), null, $locale, $node->trackerViews(), $cacheKey);
        $compilation = $this->compileYearStatistics($last_year_stats, $last_year_labels, $compilation, $locale);

        list($last_month_stats, $last_month_labels) = $cruncher
            ->getCountPerWeek(Carbon::today()->subMonth(), null, $locale, $node->trackerViews(), $cacheKey);
        $compilation = $this->compileMonthStatistics($last_month_stats, $last_month_labels, $compilation, $locale);

        list($last_week_stats, $last_week_labels) = $cruncher
            ->getCountPerDay(Carbon::today()->subWeek(), null, $locale, $node->trackerViews(), $cacheKey);
        $compilation = $this->compileWeekStatistics($last_week_stats, $last_week_labels, $compilation, $locale);

        return $compilation;
    }

}