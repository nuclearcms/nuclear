<?php

if ( ! function_exists('is_installed'))
{
    /**
     * Checks if Nuclear is installed
     *
     * @return bool
     */
    function is_installed()
    {
        return ((env('APP_STATUS', 'INSTALLED') === 'INSTALLED') && ! empty(env('DB_DATABASE')));
    }
}

if ( ! function_exists('is_request_reactor'))
{
    /**
     * Checks if the request is a reactor request
     *
     * @return bool
     */
    function is_request_reactor()
    {
        return (request()->segment(1) === config('app.reactor_prefix'));
    }
}

if ( ! function_exists('is_request_install'))
{
    /**
     * Checks if the request is a reactor request
     *
     * @return bool
     */
    function is_request_install()
    {
        return (request()->segment(1) === 'install');
    }
}

if ( ! function_exists('nuclear_version'))
{
    /**
     * Returns the current nuclear version
     *
     * @return int
     */
    function nuclear_version()
    {
        return Reactor\Providers\ReactorServiceProvider::VERSION;
    }
}

if ( ! function_exists('routes_path'))
{
    /**
     * Returns the routes path
     *
     * @param string $path
     * @return string
     */
    function routes_path($path = '')
    {
        return app()->make('path.routes') . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('uppercase'))
{
    /**
     * Converts string to uppercase depending on the language
     * This helper mainly resolves the issue for Turkish i => İ
     * This should otherwise be done with CSS
     *
     * @param string $string
     * @param string $locale
     * @return string
     */
    function uppercase($string, $locale = null)
    {
        $locale = $locale ?: App::getLocale();

        if ($locale === 'tr')
        {
            return mb_strtoupper(str_replace('i', 'İ', $string), 'UTF-8');
        }

        return mb_strtoupper($string, 'UTF-8');
    }
}

if ( ! function_exists('get_full_locale_for'))
{
    /**
     * Returns the locale count of the app
     *
     * @param string $locale
     * @param bool $trim
     * @return string
     */
    function get_full_locale_for($locale, $trim = false)
    {
        $locale = config('translatable.full_locales.' . $locale);

        return $trim ? rtrim($locale, '.UTF-8') : $locale;
    }
}

if ( ! function_exists('route_parameter'))
{
    /**
     * Getter for the translated slug
     *
     * @param string $key
     * @param string $locale
     * @return string
     */
    function route_parameter($key, $locale = null)
    {
        return app('reactor.routing.filtermaker')->getRouteParameterFor($key, $locale);
    }
}

if ( ! function_exists('get_route_parameter_for'))
{
    /**
     * Alias for route_parameter
     *
     * @deprecated
     *
     * @param string $key
     * @param string $locale
     * @return string
     */
    function get_route_parameter_for($key, $locale = null)
    {
        return route_parameter($key, $locale);
    }
}

if ( ! function_exists('is_route_parameter'))
{
    /**
     * Checks if the given key is a route parameter
     *
     * @param string $key
     * @return bool
     */
    function is_route_parameter($key)
    {
        return app('reactor.routing.filtermaker')->isRouteParameter($key);
    }
}

if ( ! function_exists('set_app_locale_with'))
{
    /**
     * Sets the app locale with given key and slug
     *
     * @param string $key
     * @param string $slug
     */
    function set_app_locale_with($key, $slug)
    {
        app('reactor.routing.filtermaker')->setAppLocaleWith($key, $slug);
    }
}

if ( ! function_exists('cached_view'))
{
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
    function cached_view($view, array $params = [], array $keywords = ['reactor.views'], $user = null, $key = null, $time = null)
    {
        return app('reactor.viewcache')->getView($view, $params, $keywords, $user, $key, $time);
    }
}

if( ! function_exists('cached_view_modules'))
{
    /**
     * Returns the modules view
     *
     * @return string
     */
    function cached_view_modules()
    {
        return app('reactor.viewcache')->getModulesView();
    }
}

if( ! function_exists('cached_view_nodes'))
{
    /**
     * Returns the nodes view
     *
     * @return string
     */
    function cached_view_nodes()
    {
        return app('reactor.viewcache')->getNodesView();
    }
}