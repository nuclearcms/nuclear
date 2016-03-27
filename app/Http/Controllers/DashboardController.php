<?php

namespace Reactor\Http\Controllers;


use Reactor\Http\Requests;
use Reactor\Nodes\Node;
use Reactor\Statistics\DashboardStatisticsCompiler;

class DashboardController extends ReactorController {

    /**
     * Display a listing of the resource.
     *
     * @param DashboardStatisticsCompiler $compiler
     * @return Response
     */
    public function index(DashboardStatisticsCompiler $compiler)
    {
        $statistics = $compiler->collectDashboardStatistics();

        $mostVisited = Node::mostVisited(10)->get();
        $recentlyVisited = Node::recentlyVisited(10)->get();
        $recentlyEdited = Node::recentlyEdited(10)->get();
        $recentlyCreated = Node::recentlyCreated(10)->get();

        return view('dashboard.index', compact('statistics', 'mostVisited', 'recentlyVisited', 'recentlyEdited', 'recentlyCreated'));
    }

    /**
     * Shows the history for the user
     *
     * @return Response
     */
    public function history()
    {
        $activities = chronicle()->getRecords(30);

        return view('dashboard.history')
            ->with(compact('activities'));
    }

}