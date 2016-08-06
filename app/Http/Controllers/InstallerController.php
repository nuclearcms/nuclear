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
        if ( ! file_exists(base_path('.env')))
        {
            copy(base_path('.env.example', '.env'));
        }

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
        return view('database');
    }

    /**
     * Sets the database information, migrates and seeds the database
     *
     * @param Request $request
     * @param InstallHelper $helper
     * @return redirect
     */
    public function postDatabase(Request $request, InstallHelper $helper)
    {
        foreach ([
                     'db_host'     => 'DB_HOST',
                     'db_port'     => 'DB_PORT',
                     'db_name'     => 'DB_DATABASE',
                     'db_username' => 'DB_USERNAME',
                     'db_password' => 'DB_PASSWORD'
                 ] as $key => $envKey)
        {
            $helper->setEnvVariable($envKey, $request->input($key));
        }
    }

}
