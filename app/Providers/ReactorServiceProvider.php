<?php

namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;

class ReactorServiceProvider extends ServiceProvider {

    const VERSION = '3.0-alpha.1';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (is_installed())
        {
            dd('register installed specific stuff like registering permissions and other db related stuff');
        }

        if (is_request_reactor())
        {
            dd('do reactor specific stuff like setting app locale');
        }
    }

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
