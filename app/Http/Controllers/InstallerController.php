<?php

namespace Reactor\Http\Controllers;


class InstallerController extends Controller {

    /**
     * Shows the "Welcome to Nuclear" page
     *
     * @return view
     */
    public function getWelcome()
    {
        return view('welcome');
    }

}
