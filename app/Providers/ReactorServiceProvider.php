<?php

namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;

class ReactorServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setTheme();
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

}
