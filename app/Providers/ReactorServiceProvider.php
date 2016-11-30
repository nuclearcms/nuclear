<?php

namespace Reactor\Providers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Nuclear\Hierarchy\Node;
use Nuclear\Hierarchy\NodeRepository;
use Nuclear\Users\Permission;
use Nuclear\Users\Role;
use Nuclear\Users\User;
use Reactor\Support\Routing\RouteFilterMaker;

class ReactorServiceProvider extends ServiceProvider {

    const VERSION = '3.0-alpha.13';

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

        $this->registerViewCache();
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

        $this->registerEventListeners();
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
            $home = $nodeRepository->getHome(false);

            view()->share('home', $home);
        }

        view()->composer('*', function ($view)
        {
            $view->with('currentUser', auth()->user());
        });

        if (is_request_reactor())
        {
            view()->composer('partials.navigation.nodes', function ($view)
            {
                $leafs = empty($id = auth()->user()->home) ?
                    Node::whereIsRoot()->defaultOrder()->get() :
                    [Node::find($id)];

                $view->with('leafs', $leafs);
            });
        }

    }

    /**
     * Registers the view cache
     */
    protected function registerViewCache()
    {
        $this->app['reactor.viewcache'] = $this->app->share(function ()
        {
            return $this->app->make('Reactor\Support\ViewCache\ReactorViewCache');
        });
    }

    /**
     * Registers event listeners
     * (mostly for view cache model events)
     */
    protected function registerEventListeners()
    {
        User::saved(function ($user)
        {
            $this->app['reactor.viewcache']
                ->flushKeywords(['userview' . $user->getKey()]);
        });

        foreach (['saved', 'deleted'] as $event)
        {
            Node::$event(function ($node)
            {
                $parent = $node->parent;

                while ($parent)
                {
                    if ($parent->hidesChildren())
                    {
                        return;
                    }

                    $parent = $parent->parent;
                }

                $this->app['reactor.viewcache']
                    ->flushKeywords(['reactor.views.navigation.nodes']);
            });

            Permission::$event(function ($permission)
            {
                $this->app['reactor.viewcache']
                    ->flushReactor();
            });

            Role::$event(function ($role)
            {
                $this->app['reactor.viewcache']
                    ->flushReactor();
            });
        }
    }

}
