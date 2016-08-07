<?php

namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;

class ReactorServiceProvider extends ServiceProvider {

    const VERSION = '3.0-alpha.1';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();

        $this->registerPaths();
    }

    /**
     * Registers helper methods
     */
    protected function registerHelpers()
    {
        require __DIR__ . '/../Support/helpers.php';
    }

    /**
     * Sets the extension path
     */
    protected function registerPaths()
    {
        $this->app['path.routes'] = base_path('routes');
    }

}
