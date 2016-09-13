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
     * @param string $locale
     * @return array
     */
    public function compileYearStatistics($stats, $labels, array $compilation, $locale)
    {
        if ( ! isset($compilation['chart']['labels']['last_year_labels']))
        {
            $compilation['chart']['labels']['last_year_labels'] = array_map(function ($date)
            {
                return $date->formatLocalized('%b');
            }, $labels);
        }

        $compilation['chart']['statistics'][$locale]['last_year_stats'] = $stats;

        return $compilation;
    }

    /**
     * Compiles month statistics
     *
     * @param array $stats
     * @param array $labels
     * @param array $compilation
     * @param string $locale
     * @return array
     */
    public function compileMonthStatistics($stats, $labels, array $compilation, $locale)
    {
        if ( ! isset($compilation['chart']['labels']['last_month_labels']))
        {
            $compilation['chart']['labels']['last_month_labels'] = array_map(function ($date)
            {
                return $date->formatLocalized('%d %b');
            }, $labels);
        }

        $compilation['chart']['statistics'][$locale]['last_month_stats'] = $stats;

        return $compilation;
    }

    /**
     * Compiles week statistics
     *
     * @param array $stats
     * @param array $labels
     * @param array $compilation
     * @param string $locale
     * @return array
     */
    public function compileWeekStatistics($stats, $labels, array $compilation, $locale)
    {
        if ( ! isset($compilation['chart']['labels']['last_week_labels']))
        {
            $compilation['chart']['labels']['last_week_labels'] = array_map(function ($date)
            {
                return $date->formatLocalized('%d %b');
            }, $labels);
        }

        $compilation['chart']['statistics'][$locale]['last_week_stats'] = $stats;

        return $compilation;
    }

}