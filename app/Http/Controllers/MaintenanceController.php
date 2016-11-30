<?php


namespace Reactor\Http\Controllers;



use Carbon\Carbon;

class MaintenanceController extends ReactorController {

    /**
     * Shows the maintenance options
     *
     * @return view
     */
    public function index()
    {
        return $this->compileView('maintenance.index');
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

        $this->notify('maintenance.' . $message);

        return redirect()->back();
    }

    /**
     * Optimizes app
     *
     * @return Redirect
     */
    public function optimizeApp()
    {
        return $this->action('optimize', 'optimized_app', ['--force' => true]);
    }

    /**
     * Caches routes
     *
     * @return Redirect
     */
    public function cacheRoutes()
    {
        return $this->action('route:cache', 'cached_routes');
    }

    /**
     * Fixes nodes tree
     *
     * @return Redirect
     */
    public function fixNodesTree()
    {
        \Kalnoy\Nestedset\Node::fixTree();

        $this->notify('maintenance.fixed_nodes_tree');

        return redirect()->back();
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
        return $this->action('reactor:backup', 'created_backup');
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
     * Clears cache
     *
     * @return Redirect
     */
    public function clearCache()
    {
        return $this->action('cache:clear', 'cleared_cache');
    }

    /**
     * Clears password resets
     *
     * @return Redirect
     */
    public function clearPasswords()
    {
        return $this->action('auth:clear-resets', 'cleared_password_resets');
    }

    /**
     * Clears cache
     *
     * @return Redirect
     */
    public function clearRoutesCache()
    {
        return $this->action('route:clear', 'cleared_routes_cache');
    }

    /**
     * Clears cache
     *
     * @return Redirect
     */
    public function clearCompiled()
    {
        return $this->action('clear-compiled', 'cleared_compiled');
    }

    /**
     * Flushes viewcache
     *
     * @return Redirect
     */
    public function viewcacheFlush()
    {
        app('reactor.viewcache')->flush();

        $this->notify('maintenance.viewcache_flushed');

        return redirect()->back();
    }

    /**
     * Flushes Reactor viewcache
     *
     * @return Redirect
     */
    public function viewcacheFlushReactor()
    {
        app('reactor.viewcache')->flushReactor();

        $this->notify('maintenance.viewcache_reactor_flushed');

        return redirect()->back();
    }

    /**
     * Flushes all site views
     *
     * @return Redirect
     */
    public function clearAllTrackerViews()
    {
        tracker()->flushAll();

        $this->notify('maintenance.cleared_tracker');

        return redirect()->back();
    }

    /**
     * Flushes site views older than a year
     *
     * @return Redirect
     */
    public function clearTrackerViewsOlderYear()
    {
        tracker()->flushOlderThan(Carbon::now()->subYear());

        $this->notify('maintenance.cleared_tracker');

        return redirect()->back();
    }

    /**
     * Flushes site views older than a month
     *
     * @return Redirect
     */
    public function clearTrackerViewsOlderMonth()
    {
        tracker()->flushOlderThan(Carbon::now()->subMonth());

        $this->notify('maintenance.cleared_tracker');

        return redirect()->back();
    }

    /**
     * Clears activities
     *
     * @return Redirect
     */
    public function clearActivities()
    {
        chronicle()->flush();

        $this->notify('maintenance.cleared_activities');

        return redirect()->back();
    }

    /**
     * Clears activities older than a year
     *
     * @return Redirect
     */
    public function clearActivitiesOlderYear()
    {
        chronicle()->flushOlderThan(Carbon::now()->subYear());

        $this->notify('maintenance.cleared_activities');

        return redirect()->back();
    }

    /**
     * Clears activities older than a month
     *
     * @return Redirect
     */
    public function clearActivitiesOlderMonth()
    {
        chronicle()->flushOlderThan(Carbon::now()->subMonth());

        $this->notify('maintenance.cleared_activities');

        return redirect()->back();
    }

}