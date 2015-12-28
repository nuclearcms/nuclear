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
     * @return Model|null
     */
    function get_reactor_document($id)
    {
        return Reactor\Documents\Media::find($id);
    }
}

if ( ! function_exists('get_reactor_gallery'))
{
    /**
     * Returns the gallery for given id
     *
     * @param string $gallery
     * @return Collection
     */
    function get_reactor_gallery($gallery)
    {
        return Reactor\Documents\Image::gallery($gallery);
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