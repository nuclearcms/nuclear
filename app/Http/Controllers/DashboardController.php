<?php


namespace Reactor\Http\Controllers;


class DashboardController extends ReactorController {

    /**
     * Shows the dashboard
     */
    public function index()
    {
        return view('dashboard.index');
    }

}