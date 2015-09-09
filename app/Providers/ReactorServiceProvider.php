<?php

namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;

class ReactorServiceProvider extends ServiceProvider {

    const VERSION = '2.0.0';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setTheme();

        $this->registerViewBindings();
    }

    /**
     * Registers helper methods
     *
     * @return void
     */
    protected function registerHelpers()
    {
        require __DIR__ . '/../Support/helpers.php';
    }

    /**
     * Sets the theme
     *
     * @return void
     */
    protected function setTheme()
    {
        // We check if the request segment has 'reactor'
        if ($this->app['request']->segment(1) === 'reactor')
        {
            \Theme::set('reactor_default');
        }
    }

    /**
     * Shares information with views
     *
     * @return void
     */
    protected function registerViewBindings()
    {
        view()->composer('*', function ($view) {
            $view->with('user', auth()->user());
        });
    }

}
