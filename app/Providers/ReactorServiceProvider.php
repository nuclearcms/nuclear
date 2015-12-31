<?php

namespace Reactor\Providers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Reactor\Nodes\Node;

class ReactorServiceProvider extends ServiceProvider {

    const VERSION = '2.0.16';

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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setTheme();

        $this->registerViewBindings();

        $this->registerCustomValidationRules();

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
            \Theme::set($this->app['config']->get('themes.active_reactor'));
        }
    }

    /**
     * Shares information with views
     *
     * @return void
     */
    protected function registerViewBindings()
    {
        view()->composer('*', function ($view)
        {
            $view->with('user', auth()->user());
        });

        view()->composer('partials.nodes', function ($view)
        {
            $view->with('leafs', Node::whereIsRoot()->get());
        });
    }

    /**
     * Registers custom validation rules
     *
     * @return void
     */
    protected function registerCustomValidationRules()
    {
        Validator::extend('unique_setting', function ($attribute, $value, $parameters, $validator)
        {
            if (isset($parameters[0]) && $value === $parameters[0])
            {
                return true;
            }

            return ! settings()->has($value);
        });

        Validator::extend('unique_setting_group', function ($attribute, $value, $parameters, $validator)
        {
            if (isset($parameters[0]) && $value === $parameters[0])
            {
                return true;
            }

            return ! settings()->hasGroup($value);
        });

        Validator::extend('date_mysql', function ($attribute, $value, $parameters, $validator)
        {
            if (\DateTime::createFromFormat('Y-m-d H:i:s', $value))
            {
                return true;
            }

            return false;
        });
    }

}
