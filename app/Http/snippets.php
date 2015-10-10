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