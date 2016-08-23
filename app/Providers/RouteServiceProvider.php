<?php

namespace Reactor\Providers;


use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Reactor\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerPatternFilters($router);

        parent::boot($router);
    }

    /**
     * Registers pattern filters
     *
     * @param Router $router
     */
    protected function registerPatternFilters(Router $router)
    {
        $router->pattern('id', '[0-9]+');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router)
        {
            // Common routes
            require routes_path('common.php');
            // Reactor routes
            require routes_path(config('themes.active_reactor') . '.php');
            // Site routes
            require routes_path(config('themes.active') . '.php');

            // Install routes
            if ( ! is_installed())
            {
                require routes_path('install.php');
            }
        });
    }

}
