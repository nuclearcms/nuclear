<?php

namespace Reactor\Statistics;


use Carbon\Carbon;
use Kenarkose\Tracker\Cruncher;

class DashboardStatisticsCompiler extends StatisticsCompiler {

    /**
     * Collects dashboard statistics
     *
     * @return array
     */
    public function compileStatistics()
    {
        $cruncher = $this->getCruncher();

        $compilation = $this->compileBaseStatistics($cruncher);

        return $this->compileTableStatistics($cruncher, $compilation);
    }

    /**
     * @param Cruncher $cruncher
     * @return array
     */
    protected function compileBaseStatistics(Cruncher $cruncher)
    {
        $last_visited = $cruncher->getLastVisited();
        $last_visited = $last_visited ? $last_visited->diffForHumans() : trans('general.never');

        $total_visits = $cruncher->getTotalVisitCount();

        $visits_today = $cruncher->getTodayCount();

        return compact('last_visited', 'total_visits', 'visits_today');
    }


    /**
     * @param Cruncher $cruncher
     * @param array $compilation
     * @return array
     */
    protected function compileTableStatistics(Cruncher $cruncher, array $compilation)
    {
        $cacheKey = 'dashboard';

        foreach(locales() as $locale)
        {
            $compilation = $this->compileTableLocaleStatistics($cruncher, $locale, $cacheKey, $compilation);
        }

        return $compilation;
    }

    /**
     * @param Cruncher $cruncher
     * @param string $locale
     * @param string $cacheKey
     * @param array $compilation
     * @return array
     */
    protected function compileTableLocaleStatistics(Cruncher $cruncher, $locale, $cacheKey, array $compilation)
    {
        list($last_year_stats, $last_year_labels) = $cruncher
            ->getCountPerMonth(Carbon::today()->subYear(), null, $locale, null, $cacheKey);
        $compilation = $this->compileYearStatistics($last_year_stats, $last_year_labels, $compilation, $locale);

        list($last_month_stats, $last_month_labels) = $cruncher
            ->getCountPerWeek(Carbon::today()->subMonth(), null, $locale, null, $cacheKey);
        $compilation = $this->compileMonthStatistics($last_month_stats, $last_month_labels, $compilation, $locale);

        list($last_week_stats, $last_week_labels) = $cruncher
            ->getCountPerDay(Carbon::today()->subWeek(), null, $locale, null, $cacheKey);
        $compilation = $this->compileWeekStatistics($last_week_stats, $last_week_labels, $compilation, $locale);

        return $compilation;
    }

}