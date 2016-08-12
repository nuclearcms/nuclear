<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Nuclear\Hierarchy\Node;
use Nuclear\Users\User;
use Reactor\Support\Install\InstallHelper;

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

        if ( ! file_exists(base_path('.env')))
        {
            copy(base_path('.env.example'), base_path('.env'));
        }

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
     * Shows the database setup view
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
             'host'     => 'DB_HOST',
             'port'     => 'DB_PORT',
             'database' => 'DB_DATABASE',
             'username' => 'DB_USERNAME',
             'password' => 'DB_PASSWORD'
         ] as $key => $envKey)
        {
            $helper->setEnvVariable($envKey, $request->input($key));
            config()->set('database.connections.' . env('DB_CONNECTION') . '.' . $key, $request->input($key));
        }

        DB::reconnect(env('DB_CONNECTION'));

        Artisan::call('migrate');
        Artisan::call('db:seed');

        return redirect()->route('install-user');
    }

    /**
     * Shows the user setup view
     *
     * @return view
     */
    public function getUser()
    {
        return view('user');
    }

    /**
     * Creates the initial user after validating information
     *
     * @param Request $request
     * @return redirect
     */
    public function postUser(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        chronicle()->pauseRecording();
        $user = User::create($request->all());
        $user->assignRole('SUPERADMIN');

        return redirect()->route('install-settings');
    }

    /**
     * Shows the site setup view
     *
     * @return view
     */
    public function getSettings()
    {
        return view('settings');
    }

    /**
     * Processes site settings
     *
     * @param Request $request
     * @param InstallHelper $helper
     * @return redirect
     */
    public function postSettings(Request $request, InstallHelper $helper)
    {
        $this->validate($request, [
            'base_url' => 'required|url',
            'reactor_prefix' => 'required|alpha_dash',
        ]);

        $helper->setEnvVariable('REACTOR_PREFIX', $request->get('reactor_prefix'));
        $helper->setEnvVariable('APP_URL', $request->get('base_url'));

        return redirect()->route('install-site');
    }

    /**
     * Shows the site information setup view
     *
     * @return view
     */
    public function getSite()
    {
        return view('site');
    }

    /**
     * Populates site information
     *
     * @param Request $request
     * @param InstallHelper $helper
     * @return redirect
     */
    public function postSite(Request $request, InstallHelper $helper)
    {
        $this->validate($request, [
            'meta_title' => 'required'
        ]);

        chronicle()->pauseRecording();

        $user = User::first();

        $home = Node::published()
            ->whereHome(1)
            ->firstOrFail();

        $home->associateOwner($user);

        $home->fill($request->only(['meta_title', 'meta_keywords', 'meta_description', 'meta_author']));
        $home->save();

        Artisan::call('key:generate');
        $helper->setEnvVariable('APP_STATUS', 'INSTALLED');

        return redirect()->route('install-complete');
    }

    /**
     * Shows the completed view
     *
     * @return view
     */
    public function getComplete()
    {
        return view('complete');
    }

}
