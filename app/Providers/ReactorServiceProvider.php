<?php

namespace Reactor\Providers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Nuclear\Hierarchy\Node;
use Nuclear\Hierarchy\NodeRepository;
use Reactor\Support\Routing\RouteFilterMaker;

class ReactorServiceProvider extends ServiceProvider {

    const VERSION = '3.0-alpha.4';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();

        $this->registerPaths();

        $this->registerFilterMaker();
    }

    /**
     * Registers helper methods
     */
    protected function registerHelpers()
    {
        require_once __DIR__ . '/../Support/helpers.php';

        require_once __DIR__ . '/../Html/Builders/snippets.php';
    }

    /**
     * Sets the extension path
     */
    protected function registerPaths()
    {
        $this->app['path.routes'] = base_path('routes');
    }

    /**
     * Registers the filter maker
     */
    protected function registerFilterMaker()
    {
        $this->app['reactor.routing.filtermaker'] = $this->app->share(function ()
        {
            return new RouteFilterMaker;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @param NodeRepository $nodeRepository
     */
    public function boot(NodeRepository $nodeRepository)
    {
        $this->registerValidationRules();

        $this->registerViewBindings($nodeRepository);
    }

    /**
     * Registers validation rules
     */
    protected function registerValidationRules()
    {
        $rules = [
            'not_reserved_name' => 'NotReservedName',
            'date_mysql'        => 'DateMysql'
        ];

        foreach ($rules as $name => $rule)
        {
            Validator::extend($name, 'Reactor\Support\Validation\FormValidator@validate' . $rule);
        }
    }

    /**
     * Registers view bindings
     *
     * @param NodeRepository $nodeRepository
     */
    protected function registerViewBindings(NodeRepository $nodeRepository)
    {
        if ( ! is_installed())
        {
            return;
        }

        if ( ! is_request_reactor())
        {
            view()->share('home', $nodeRepository->getHome(false));
        }

        view()->composer('*', function ($view) use ($nodeRepository)
        {
            $view->with('currentUser', auth()->user());
        });

        if (is_request_reactor())
        {
            view()->composer('partials.navigation.nodes', function ($view)
            {
                $view->with('leafs', Node::whereIsRoot()->defaultOrder()->get());
            });
        }

    }

}
