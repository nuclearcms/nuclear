<?php

namespace Reactor\Statistics;


use Kenarkose\Tracker\Cruncher;

abstract class StatisticsCompiler {

    /**
     * Cruncher instance
     *
     * @var Cruncher
     */
    protected $cruncher;

    /**
     * Compiler constructor.
     *
     * @param Cruncher $cruncher
     */
    public function __construct(Cruncher $cruncher)
    {
        $this->cruncher = $cruncher;
    }

    /**
     * @return Cruncher
     */
    public function getCruncher()
    {
        return $this->cruncher;
    }

    /**
     * Compiles year statistics
     *
     * @param array $stats
     * @param array $labels
     * @param array $compilation
     * @return array
     */
    public function compileYearStatistics($stats, $labels, $compilation)
    {
        $labels = array_map(function ($date)
        {
            return $date->formatLocalized('%b');
        }, $labels);

        $compilation['last_year_stats'] = $stats;
        $compilation['last_year_labels'] = $labels;

        return $compilation;
    }

    /**
     * Compiles month statistics
     *
     * @param array $stats
     * @param array $labels
     * @param array $compilation
     * @return array
     */
    public function compileMonthStatistics($stats, $labels, $compilation)
    {
        $labels = array_map(function ($date)
        {
            return $date->formatLocalized('%d %b');
        }, $labels);

        $compilation['last_month_stats'] = $stats;
        $compilation['last_month_labels'] = $labels;

        return $compilation;
    }

    /**
     * Compiles week statistics
     *
     * @param array $stats
     * @param array $labels
     * @param array $compilation
     * @return array
     */
    public function compileWeekStatistics($stats, $labels, $compilation)
    {
        $labels = array_map(function ($date)
        {
            return $date->formatLocalized('%d %b');
        }, $labels);

        $compilation['last_week_stats'] = $stats;
        $compilation['last_week_labels'] = $labels;

        return $compilation;
    }

}