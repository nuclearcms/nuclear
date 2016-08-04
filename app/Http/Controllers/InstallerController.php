<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Install\InstallHelper;

class InstallerController extends Controller {

    /**
     * Shows the "Welcome to Nuclear" page
     *
     * @param InstallHelper $helper
     * @return view
     */
    public function getWelcome(InstallHelper $helper)
    {
        $missing = $helper->checkRequirements();

        return view('welcome', compact('missing'));
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

        return redirect()->route('install-database');
    }

    /**
     * Shows the database setup screen
     *
     * @return view
     */
    public function getDatabase()
    {

    }

}
