<?php


namespace Reactor\Support\Routing;


use Illuminate\Routing\Router;

class RouteFilterMaker {

    /** @var array */
    protected $filters;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filters = config('route-filters', []);
    }

    /**
     * Registers pattern filters
     *
     * @param Router $router
     */
    public function registerPatternFilters(Router $router)
    {
        foreach ($this->filters as $key => $filter)
        {
            $router->pattern($key, implode('|', $filter));
        }
    }

    /**
     * Getter for the translated slug
     *
     * @param string $key
     * @param string $locale
     * @return string
     */
    public function getRouteParameterFor($key, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        return $this->filters[$key][$locale];
    }

    /**
     * Returns the locale for given key and slug
     *
     * @param string $key
     * @param string $currentSlug
     * @return string
     */
    public function getLocaleFor($key, $currentSlug)
    {
        $slugs = $this->filters[$key];

        foreach ($slugs as $locale => $slug)
        {
            if ($slug === $currentSlug)
            {
                return $locale;
            }
        }

        throw new \RuntimeException('Locale for the slug "' . $currentSlug . '" was not found.');
    }

    /**
     * Checks if the given key is a route parameter
     *
     * @param string $key
     * @return bool
     */
    public function isRouteParameter($key)
    {
        return isset($this->filters[$key]);
    }

    /**
     * Sets the app locale with given key and slug
     *
     * @param string $key
     * @param string $slug
     */
    public function setAppLocaleWith($key, $slug)
    {
        $locale = $this->getLocaleFor($key, $slug);

        set_app_locale($locale);
    }

}