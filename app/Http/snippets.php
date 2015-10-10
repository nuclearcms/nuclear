<?php

if ( ! function_exists('delete_form'))
{
    /**
     * Snippet for for outputting html for delete forms
     *
     * @param string $action
     * @param string $text
     * @param string $icon
     * @return string
     */
    function delete_form($action, $text, $icon = 'icon-trash')
    {
        return sprintf('<form action="%s" method="POST">' .
            method_field('DELETE') . csrf_field() .
            '<button type="submit" class="option-delete">
                <i class="%s"></i> %s
            </button>',
            $action, $icon, $text);
    }
}

if ( ! function_exists('no_results_row'))
{
    /**
     * Snippet for displaying no results row on tables
     *
     * @param string $message
     * @return string
     */
    function no_results_row($message = 'general.search_no_results')
    {
        return '<tr>
            <td colspan="42" class="content-noresults">' . trans($message) . '</td>
        </tr>';
    }
}

if ( ! function_exists('content_options_open'))
{
    /**
     * Snippet for displaying content options opening
     *
     * @return string
     */
    function content_options_open()
    {
        return '<td class="content-item-options">
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-middle">
                <li class="list-header">' . uppercase(trans('general.options')) . '</li>';
    }
}

if ( ! function_exists('content_options_close'))
{
    /**
     * Snippet for displaying content options closing
     *
     * @return string
     */
    function content_options_close()
    {
        return '</ul></td>';
    }
}

if ( ! function_exists('back_to_all_link'))
{
    /**
     * Snippet for generating back links (mainly for search pages)
     *
     * @param string $link
     * @param string $text
     * @return string
     */
    function back_to_all_link($link, $text)
    {
        return sprintf('<a class="button back-link" href="%s">
            <i class="icon-left-thin"></i>%s</a>', $link, trans($text));
    }
}

if ( ! function_exists('content_table_open'))
{
    /**
     * Snippet for outputting opening of content tables
     *
     * @param bool $sub
     * @param string|null $wrapper
     * @return string
     */
    function content_table_open($sub = false, $wrapper = null)
    {
        if ($sub && is_null($wrapper))
        {
            $wrapper = '<div class="content-list-container content-list-sub-container">';
        }

        $thumbnail = ($sub) ? '' : '<th></th>';

        return sprintf('%s<table class="content-list">
            <thead class="content-header">
                <tr>%s',
            $wrapper, $thumbnail);
    }
}

if ( ! function_exists('content_table_middle'))
{
    /**
     * Snippet for outputting middle parts of content tables
     *
     * @return string
     */
    function content_table_middle()
    {
        return '<th></th>
            </tr>
        </thead>
        <tbody class="content-body">';
    }
}

if ( ! function_exists('content_table_close'))
{
    /**
     * Snippet for outputting closing of content tables
     *
     * @param bool $sub
     * @param string|null $wrapper
     * @return string
     */
    function content_table_close($sub = false, $wrapper = null)
    {
        if ($sub and is_null($wrapper))
        {
            $wrapper = '</div>';
        }

        return sprintf('</tbody></table>%s', $wrapper);
    }
}