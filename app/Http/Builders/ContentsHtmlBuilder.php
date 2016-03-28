<?php

namespace Reactor\Http\Builders;


class ContentsHtmlBuilder {

    /**
     * Snippet for outputting opening of content tables
     *
     * @param bool $sub
     * @param string|null $wrapper
     * @return string
     */
    public function contentTableOpen($sub = false, $wrapper = null)
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

    /**
     * Snippet for outputting middle parts of content tables
     *
     * @return string
     */
    public function contentTableMiddle()
    {
        return '<th></th>
            </tr>
        </thead>
        <tbody class="content-body">';
    }

    /**
     * Snippet for outputting closing of content tables
     *
     * @param bool $sub
     * @param string|null $wrapper
     * @return string
     */
    public function contentTableClose($sub = false, $wrapper = null)
    {
        if ($sub and is_null($wrapper))
        {
            $wrapper = '</div>';
        }

        return sprintf('</tbody></table>%s', $wrapper);
    }

    /**
     * Snippet for displaying content options opening
     *
     * @param $header
     * @param bool $table
     * @return string
     */
    public function contentOptionsOpen($header = null, $table = true)
    {
        return sprintf('%s
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-middle">%s',
            $table ? '<td class="content-item-options">' : '',
            $header ?: '<li class="list-header">' . uppercase(trans('general.options')) . '</li>');
    }

    /**
     * Snippet for displaying content options closing
     *
     * @param bool $table
     * @return string
     */
    public function contentOptionsClose($table = true)
    {
        return '</ul>' . ($table) ? '</td>' : '';
    }

    /**
     * Snippet for displaying no results row on tables
     *
     * @param string $message
     * @return string
     */
    public function noResultsRow($message = 'general.search_no_results')
    {
        return '<tr>
            <td colspan="42" class="content-noresults">' . trans($message) . '</td>
        </tr>';
    }

    /**
     * Snippet for generating back links (mainly for search pages)
     *
     * @param string $link
     * @param string $text
     * @return string
     */
    public function backToAllLink($link, $text)
    {
        return sprintf('<a class="button back-link" href="%s">
            <i class="icon-left-thin"></i>%s</a>', $link, trans($text));
    }
    
}