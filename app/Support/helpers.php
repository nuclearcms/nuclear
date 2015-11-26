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

if ( ! function_exists('get_field_document'))
{
    /**
     * Returns the document for given id
     *
     * @param int $id
     * @return Model|null
     */
    function get_document($id)
    {
        return Reactor\Documents\Media::find($id);
    }
}

if ( ! function_exists('get_field_gallery'))
{
    /**
     * Returns the gallery for given id
     *
     * @param string $gallery
     * @return Collection
     */
    function get_gallery($gallery)
    {
        return Reactor\Documents\Image::gallery($gallery);
    }
}