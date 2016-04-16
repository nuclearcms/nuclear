<?php

if ( ! function_exists('is_reactor'))
{
    /**
     * Checks if the request is a reactor request
     *
     * @return bool
     */
    function is_reactor()
    {
        return (request()->segment(1) === config('app.reactor_prefix'));
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

if ( ! function_exists('uppercase'))
{
    /**
     * Converts string to uppercase depending on the language
     * This helper mainly resolves the issue for Turkish i => İ
     * This should otherwise be done with CSS
     *
     * @param string
     * @return string
     */
    function uppercase($string)
    {
        if (App::getLocale() === 'tr')
        {
            return mb_strtoupper(str_replace('i', 'İ', $string), 'UTF-8');
        }

        return mb_strtoupper($string, 'UTF-8');
    }
}

if ( ! function_exists('locale_count'))
{
    /**
     * Returns the locale count of the app
     *
     * @return int
     */
    function locale_count()
    {
        return count(config('translatable.locales'));
    }
}

if ( ! function_exists('get_reactor_document'))
{
    /**
     * Returns the document for given id
     *
     * @param int $id
     * @return Media
     */
    function get_reactor_document($id)
    {
        return app('reactor.documents.repository')->getDocument($id);
    }
}

if ( ! function_exists('get_reactor_gallery'))
{
    /**
     * Returns the gallery for given id
     *
     * @param int|string|array $ids
     * @return Collection
     */
    function get_reactor_gallery($ids)
    {
        return app('reactor.documents.repository')->getGallery($ids);
    }
}

if ( ! function_exists('get_reactor_cover'))
{
    /**
     * Returns the cover for given ids
     *
     * @param int|string|array $ids
     * @return Media
     */
    function get_reactor_cover($ids)
    {
        return app('reactor.documents.repository')->getCover($ids);
    }
}

if ( ! function_exists('extension_path'))
{
    /**
     * Returns the extension path
     *
     * @param string $path
     * @return string
     */
    function extension_path($path = '')
    {
        return app()->make('path.extension') . ($path ? '/' . $path : $path);
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

if ( ! function_exists('get_node_by_id'))
{
    /**
     * Returns the node by given id
     * (alias for NodeRepository::getNodeById)
     *
     * @param int $id
     * @param bool $published
     * @return Node
     */
    function get_node_by_id($id, $published = true)
    {
        return app()->make('Reactor\Nodes\NodeRepository')
            ->getNodeById($id, $published);
    }
}

if ( ! function_exists('get_nodes_by_ids'))
{
    /**
     * Returns the nodes by given ids
     * (alias for NodeRepository::getNodesByIds)
     *
     * @param array|string $ids
     * @param bool $published
     * @return Collection
     */
    function get_nodes_by_ids($ids, $published = true)
    {
        return app()->make('Reactor\Nodes\NodeRepository')
            ->getNodesByIds($ids, $published);
    }
}

if ( ! function_exists('set_app_locale'))
{
    /**
     * Sets the app locale
     *
     * @param string $locale
     * @return void
     */
    function set_app_locale($locale = null)
    {
        app('reactor.support.locale')->setAppLocale($locale);
    }
}

if ( ! function_exists('set_time_locale'))
{
    /**
     * Sets the time locale
     *
     * @param string $locale
     * @return void
     */
    function set_time_locale($locale = null)
    {
        app('reactor.support.locale')->setTimeLocale($locale);
    }

}