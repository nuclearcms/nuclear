<?php


namespace Reactor\Providers;


use Illuminate\Support\ServiceProvider;
use Nuclear\Hierarchy\Node;
use Nuclear\Hierarchy\NodeRepository;

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
     * @param NodeRepository $nodeRepository
     * @return void
     */
    public function boot(NodeRepository $nodeRepository)
    {
        view()->composer('*', function ($view) use ($nodeRepository)
        {
            $view->with('user', auth()->user());
            $view->with('home', $nodeRepository->getHome());
        });

        view()->composer('partials.navigation.nodes', function ($view)
        {
            $view->with('leafs', Node::whereIsRoot()->defaultOrder()->get());
        });
    }
}