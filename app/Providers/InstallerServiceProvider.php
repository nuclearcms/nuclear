<?php


namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
    }

    /**
     * Registers install routes
     */
    protected function registerRoutes()
    {
        require routes_path('install.php');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}