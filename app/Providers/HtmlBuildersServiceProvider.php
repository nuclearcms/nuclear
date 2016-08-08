<?php

namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;

class HtmlBuildersServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'reactor.builders.forms',
            'reactor.builders.navigation'
        ];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFormsHtmlBuilder();
        $this->registerNavigationHtmlBuilder();
    }

    /**
     * Registers forms html builder
     */
    protected function registerFormsHtmlBuilder()
    {
        $this->app['reactor.builders.forms'] = $this->app->share(function () {
            return $this->app->make('Reactor\Html\FormsHtmlBuilder');
        });
    }

    /**
     * Registers navigation html builder
     */
    protected function registerNavigationHtmlBuilder()
    {
        $this->app['reactor.builders.navigation'] = $this->app->share(function () {
            return $this->app->make('Reactor\Html\NavigationHtmlBuilder');
        });
    }

}