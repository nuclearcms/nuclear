<?php

namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;
use Reactor\Nodes\Node;

class ViewBindingsServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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

        // Added 'reactor' before nodes in the view name to prevent possible conflicts
        view()->composer('partials.reactor_nodes', function ($view)
        {
            $view->with('leafs', Node::whereIsRoot()->defaultOrder()->get());
        });
    }

}