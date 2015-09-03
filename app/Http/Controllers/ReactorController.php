<?php

namespace Reactor\Http\Controllers;


abstract class ReactorController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

}
