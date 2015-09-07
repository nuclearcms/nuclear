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
        return view('dashboard');
    }

}