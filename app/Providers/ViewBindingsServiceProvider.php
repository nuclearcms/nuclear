<?php


namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;

class ViewBindingsServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view)
        {
            $view->with('user', auth()->user());
        });
    }
}