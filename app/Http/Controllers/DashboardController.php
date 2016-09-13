<?php


namespace Reactor\Http\Controllers;


use Nuclear\Hierarchy\Node;
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

        $mostVisited = Node::mostVisited(10)->get();
        $recentlyVisited = Node::recentlyVisited(10)->get();
        $recentlyEdited = Node::recentlyEdited(10)->get();
        $recentlyCreated = Node::recentlyCreated(10)->get();

        return $this->compileView('dashboard.index', compact('statistics', 'mostVisited', 'recentlyVisited', 'recentlyEdited', 'recentlyCreated'), trans('general.dashboard'));
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