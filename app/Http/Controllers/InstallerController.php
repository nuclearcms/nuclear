<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Install\InstallHelper;

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

    /**
     * Sets the app locale and timezone
     *
     * @param Request $request
     * @param InstallHelper $helper
     * @return redirect
     */
    public function postWelcome(Request $request, InstallHelper $helper)
    {
        $helper->setEnvVariable('REACTOR_LOCALE', $request->get('language'));
        $helper->setEnvVariable('APP_TIMEZONE', $request->get('timezone'));

        return redirect()->route('install-requirements');
    }

}
