<?php

namespace Reactor\Http\Controllers;



class AdvancedOptionsController extends ReactorController {

    /**
     * Get the list of advanced options
     *
     * @return Response
     */
    public function index()
    {
        return view('advanced.index');
    }

    /**
     * Action response
     *
     * @param string $action
     * @param string $message
     * @param array $options
     * @return Redirect
     */
    protected function action($action, $message, array $options = [])
    {
        \Artisan::call($action, $options);

        $this->notify('advanced.' . $message);

        return redirect()->back();
    }

    /**
     * Optimizes app
     *
     * @return Redirect
     */
    public function optimizeApp()
    {
        return $this->action('optimize', 'app_optimized', ['--force' => true]);
    }

    /**
     * Caches routes
     *
     * @return Redirect
     */
    public function cacheRoutes()
    {
        return $this->action('route:cache', 'routes_cached');
    }

    /**
     * Caches routes
     *
     * @return Redirect
     */
    public function regenerateKey()
    {
        return $this->action('key:generate', 'regenerated_key');
    }

    /**
     * Creates backup
     *
     * @return Redirect
     */
    public function createBackup()
    {
        return $this->action('backup:run', 'created_backup');
    }

    /**
     * Clears password resets
     *
     * @return Redirect
     */
    public function clearPasswords()
    {
        return $this->action('auth:clear-resets', 'cleared_resets');
    }

    /**
     * Clears views
     *
     * @return Redirect
     */
    public function clearViews()
    {
        return $this->action('view:clear', 'cleared_views');
    }

    /**
     * Clears activities
     *
     * @return Redirect
     */
    public function clearActivities()
    {
        chronicle()->flush();

        $this->notify('advanced.cleared_activities');

        return redirect()->back();
    }

    /**
     * Clears cache
     *
     * @return Redirect
     */
    public function clearCache()
    {
        return $this->action('cache:clear', 'cleared_cache');
    }

}