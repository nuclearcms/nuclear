<?php

namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;
use Theme;

class ReactorServiceProvider extends ServiceProvider {

    const VERSION = '2.7.1';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();

        $this->registerSupporters();

        $this->registerRepositories();

        $this->registerPaths();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setTheme();

        $this->setAppLocale();

        $this->setTimeLocale();
    }

    /**
     * Registers helper methods
     *
     * @return void
     */
    protected function registerHelpers()
    {
        require __DIR__ . '/../Support/helpers.php';

        require __DIR__ . '/../Http/snippets.php';
    }

    /**
     * Registers support classes
     *
     * @return void
     */
    protected function registerSupporters()
    {
        $this->app->singleton(
            'reactor.support.locale',
            'Reactor\Support\LocaleManager'
        );
    }

    /**
     * Registers the common repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->app->bindShared('reactor.documents.repository', function ()
        {
            return $this->app->make('Reactor\Documents\DocumentsRepository');
        });
    }

    /**
     * Sets the extension path
     *
     * @return void
     */
    protected function registerPaths()
    {
        $this->app['path.extension'] = base_path('extension');
        $this->app['path.routes'] = base_path('routes');
    }

    /**
     * Sets the app locale
     */
    protected function setAppLocale()
    {
        set_app_locale();
    }

    /**
     * Sets the time locale for locale based time outputting
     */
    protected function setTimeLocale()
    {
        set_time_locale();
    }

    /**
     * Sets the theme
     *
     * @return void
     */
    protected function setTheme()
    {
        // We check if the request segment has 'reactor'
        if (is_reactor())
        {
            Theme::set($this->app['config']->get('themes.active_reactor'));
        }
    }

}
