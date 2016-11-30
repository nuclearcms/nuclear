<?php


namespace Reactor\Support\ViewCache;


use Illuminate\Cache\Repository;

class ViewCache {

    /* @var Repository */
    protected $cache;

    /**
     * Constructor
     *
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Flushes cache with key
     *
     * @param string $view
     * @param int $user
     * @param string $key
     */
    public function flushKey($view, $user = null, $key = null)
    {
        $key = $this->determineKey($key, $view, $user);

        $this->cache->forget($key);
    }

    /**
     * Flushes cache by keywords
     *
     * @param array $keywords
     */
    public function flushKeywords(array $keywords)
    {
        $keywords[] = 'viewcache';
        $this->cache->keywords($keywords)->flush();
    }

    /**
     * Flushes all view cache
     */
    public function flush()
    {
        $this->cache->keywords(['viewcache'])->flush();
    }

    /**
     * Returns a view either from cache or generating it fresh then caching it
     *
     * @param string $view
     * @param array $params
     * @param array $keywords
     * @param int $user
     * @param string $key
     * @param int $time
     * @return string
     */
    public function getView($view, array $params = [], array $keywords = ['reactor.views'], $user = null, $key = null, $time = null)
    {
        $key = $this->determineKey($key, $view, $user);
        $keywords = $this->determineKeywords($keywords, $user);

        if ($cachedView = $this->cache->keywords($keywords)->get($key))
        {
            return $cachedView;
        }

        $view = $this->generateView($view, $params);

        $this->storeView($view, $key, $time, $keywords);

        return $view;
    }

    /**
     * Determines the key for the view cache
     *
     * @param string $key
     * @param string $view
     * @param int $user
     * @return string
     */
    protected function determineKey($key, $view, $user)
    {
        $key = $key ?: $view;

        return $user ? $key . '.user.' . $user : $key;
    }

    /**
     * Returns the keywords for the view cache
     *
     * @param array $keywords
     * @param int $user
     * @return array
     */
    protected function determineKeywords(array $keywords, $user)
    {
        $keywords[] = 'viewcache';

        if ($user)
        {
            $keywords[] = 'userview.' . $user;
        }

        return $keywords;
    }

    /**
     * Returns the generated view with given name and parameters
     *
     * @param string $view
     * @param array $params
     * @return string
     */
    protected function generateView($view, array $params)
    {
        return view($view, $params)->render();
    }

    /**
     * Stores the generated view in cache
     *
     * @param string $view
     * @param string $key
     * @param int $time
     * @param array $keywords
     */
    protected function storeView($view, $key, $time, array $keywords)
    {
        $cache = $this->cache->keywords($keywords);

        if ($time)
        {
            $cache->put($key, $view, $time);
        } else
        {
            $cache->forever($key, $view);
        }
    }

}