<?php


namespace Reactor\Support\ViewCache;


use Illuminate\Cache\Repository;

class ReactorViewCache extends ViewCache {

    /** @var User */
    protected $user;

    /**
     * Constructor
     *
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        parent::__construct($cache);

        $this->user = auth()->user();
    }

    /**
     * Returns the modules view
     *
     * @return string
     */
    public function getModulesView()
    {
        return $this->getView(
            'partials.navigation.modules',
            [],
            ['reactor.views.navigation.modules'],
            $this->user->getKey()
        );
    }

    /**
     * Returns the nodes view
     *
     * @return string
     */
    public function getNodesView()
    {
        return $this->getView(
            'partials.navigation.nodes',
            [],
            ['reactor.views.navigation.nodes'],
            $this->user->getKey()
        );
    }

    /**
     * Flushes reactor viewcache
     */
    public function flushReactor()
    {
        $this->flushKeywords(['reactor.views.navigation.nodes', 'reactor.views.navigation.modules']);
    }

}