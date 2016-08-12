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
            'reactor.builders.contents',
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
        $this->registerContentsHtmlBuilder();
        $this->registerFormsHtmlBuilder();
        $this->registerNavigationHtmlBuilder();
    }

    /**
     * Registers contents html builder
     */
    protected function registerContentsHtmlBuilder()
    {
        $this->app['reactor.builders.contents'] = $this->app->share(function () {
            return $this->app->make('Reactor\Html\Builders\ContentsHtmlBuilder');
        });
    }

    /**
     * Registers forms html builder
     */
    protected function registerFormsHtmlBuilder()
    {
        $this->app['reactor.builders.forms'] = $this->app->share(function () {
            return $this->app->make('Reactor\Html\Builders\FormsHtmlBuilder');
        });
    }

    /**
     * Registers navigation html builder
     */
    protected function registerNavigationHtmlBuilder()
    {
        $this->app['reactor.builders.navigation'] = $this->app->share(function () {
            return $this->app->make('Reactor\Html\Builders\NavigationHtmlBuilder');
        });
    }

}