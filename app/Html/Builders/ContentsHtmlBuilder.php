<?php

namespace Reactor\Html\Builders;


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
            $wrapper = '<div class="content-list-container content-list-container--sub">';
        }

        $thumbnail = ($sub) ? '' : '<th class="content-list__cell content-list__cell--head"></th>';

        return sprintf('%s<table class="content-list">
            <thead class="content-header">
                <tr class="content-list__row">%s',
            $wrapper, $thumbnail);
    }

    /**
     * Snippet for outputting middle parts of content tables
     *
     * @return string
     */
    public function contentTableMiddle()
    {
        return '<th class="content-list__cell content-list__cell--head"></th>
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
     * Snippet for displaying the selection/thumbnail column
     *
     * @param int $id
     * @return string
     */
    public function contentListThumbnail($id)
    {
        return '<td class="content-list__cell content-list__cell--thumbnail">' .
            \Form::checkbox('selected[]', $id, false, ['class' => 'content-list__checkbox']) .
        '</td>';
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
            <div class="has-dropdown">
                <i class="dropdown-icon icon-ellipsis-vertical"></i>
                <div class="dropdown">
                    <div class="dropdown__info">%s</div>
                    <ul class="dropdown-sub">',
            $table ? '<td class="content-list__cell content-list__cell--options">' : '',
            $header ?: uppercase(trans('general.options')));
    }

    /**
     * Snippet for displaying content options closing
     *
     * @param bool $table
     * @return string
     */
    public function contentOptionsClose($table = true)
    {
        return '</ul></div></div>' . (($table) ? '</td>' : '');
    }

    /**
     * Snippet for displaying standard content options
     *
     * @param string $key
     * @param int $id
     * @return string
     */
    public function contentOptions($key, $id)
    {
        $html = '<li class="dropdown-sub__item">
            <a href="' . route('reactor.' . $key . '.edit', $id) . '">
                <i class="icon-pencil"></i>' . trans($key . '.edit') . '</a>
        </li>
        <li class="dropdown-sub__item dropdown-sub__item--delete">' .
            delete_form(
                route('reactor.' . $key . '.destroy', $id),
                trans($key . '.destroy')) .
        '</li>';

        return $this->contentOptionsOpen() . $html . $this->contentOptionsClose();
    }

    /**
     * Snippet for displaying header action opening
     *
     * @param string $text
     * @param string $class
     * @param bool $secondary
     * @return string
     */
    public function headerActionOpen($text, $class = "header__action--left", $secondary = false)
    {
        return sprintf('<div class="header__action %s %s">
            <div class="header__action-header">%s</div>
            <div class="header__action-options">',
            $class,
            $secondary ? 'header__action--secondary' : '',
            uppercase(trans($text)));
    }

    /**
     * Snippet for displaying header action closing
     *
     * @return string
     */
    public function headerActionClose()
    {
        return '</div></div>';
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
            <td colspan="42" class="content-list__no-results">' . trans($message) . '</td>
        </tr>';
    }

    /**
     * Snippet for generating back links (mainly for search pages)
     *
     * @param string $key
     * @return string
     */
    public function backToAllLink($key)
    {
        return action_button(route('reactor.' . $key . '.index'), 'icon-arrow-left' , trans($key . '.all'), 'button--emphasis', 'l');
    }

}