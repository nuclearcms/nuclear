<?php


namespace Reactor\Http\Controllers;


use Reactor\Statistics\DashboardStatisticsCompiler;

class DashboardController extends ReactorController {

    /**
     * Shows the dashboard
     * @param DashboardStatisticsCompiler $compiler
     * @return view
     */
    public function index(DashboardStatisticsCompiler $compiler)
    {
        $statistics = $compiler->compileStatistics();

        return $this->compileView('dashboard.index', compact('statistics'), trans('general.dashboard'));
    }

    /**
     * Shows the activity for the user
     *
     * @return Response
     */
    public function activity()
    {
        $activities = chronicle()->getRecords(30);

        return $this->compileView('dashboard.activity', compact('activities'), trans('general.recent_activity'));
    }

}