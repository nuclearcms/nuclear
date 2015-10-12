<?php

namespace Reactor\Http\Controllers;


use Reactor\Http\Requests;

class DashboardController extends ReactorController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard.index');
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