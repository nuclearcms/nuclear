<?php

if ( ! function_exists('delete_form'))
{
    /**
     * Snippet for for outputting html for delete forms
     *
     * @param string $action
     * @param string $text
     * @param string $input
     * @param string $icon
     * @return string
     */
    function delete_form($action, $text, $input = '', $icon = 'icon-trash')
    {
        return sprintf('<form action="%s" method="POST">' .
            method_field('DELETE') . csrf_field() .
            '%s<button type="submit" class="option-delete">
                <i class="%s"></i> %s
            </button></form>',
            $action, $input, $icon, $text);
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
     * @param $header
     * @return string
     */
    function content_options_open($header = null)
    {
        return sprintf('<td class="content-item-options">
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-middle">%s',
            $header ?: '<li class="list-header">' . uppercase(trans('general.options')) . '</li>');
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

if ( ! function_exists('submit_button'))
{
    /**
     * Snippet for generating a submit button
     *
     * @param string $icon
     * @param string $text
     * @param string $type
     * @return string
     */
    function submit_button($icon, $text = '', $type = 'submit')
    {
        $class = empty($text) ? 'button-icon-primary' : 'button-icon';

        return sprintf('<button class="button button-emphasized %s" type="%s">
            %s <i class="%s"></i>
        </button>',
            $class,
            $type,
            uppercase(trans($text)),
            $icon);
    }

}

if ( ! function_exists('action_button'))
{
    /**
     * Snippet for generating an action button
     *
     * @param string $link
     * @param string $icon
     * @param bool $secondary
     * @param string|null $text
     * @return string
     */
    function action_button($link, $icon, $secondary = false, $text = null)
    {
        return sprintf('<a href="%s" class="button button-emphasized %s %s">
            %s<i class="%s"></i>
        </a>',
            $link,
            (is_null($text)) ? 'button-icon-primary' : '',
            ($secondary) ? 'button-secondary' : '',
            ( ! is_null($text)) ? uppercase(trans($text)) . ' ' : '',
            $icon);
    }
}

if ( ! function_exists('navigation_module_open'))
{
    /**
     * Snippet for generating navigation menu openings
     *
     * @param string $icon
     * @param string $title
     * @return string
     */
    function navigation_module_open($icon, $title)
    {
        return sprintf('<li class="navigation-module">
            <i class="%s"></i>
            <div class="module-dropdown material-middle">
                <div class="module-info">%s</div>
                <ul class="module-sub">', $icon, uppercase(trans($title)));
    }
}

if ( ! function_exists('navigation_module_close'))
{
    /**
     * Snippet for generating navigation menu closings
     *
     * @return string
     */
    function navigation_module_close()
    {
        return '</ul></div></li>';
    }
}

if ( ! function_exists('navigation_module_link'))
{
    /**
     * Snippet for generating module links
     *
     * @param string $route
     * @param string $icon
     * @param string $title
     * @param mixed $parameters
     * @return string
     */
    function navigation_module_link($route, $icon, $title, $parameters = [])
    {
        return sprintf('<li><a href="%s"><i class="%s"></i>%s</a>',
            route($route, $parameters),
            $icon,
            trans($title)
        );
    }
}

if ( ! function_exists('node_options_list'))
{
    /**
     * Snippet for generating node options
     *
     * @param $node
     * @return string
     */
    function node_options_list($node)
    {
        $list = '<div class="node-options">' . content_options_open(
            '<li class="options-header" style="background-color:' . $node->nodeType->color . ';">'
            . uppercase($node->nodeType->label) .
            '</li>'
        );

        if ( ! $node->sterile)
        {
            $list .= '<li>
                <a href="' . route('reactor.contents.create', $node->getKey()) . '">
                    <i class="icon-plus"></i>' . trans('nodes.add_child') . '</a>
            </li>';
        }

        $list .= '<li>
            <a href="' . route('reactor.contents.edit', $node->getKey()) . '">
                <i class="icon-pencil"></i>' . trans('nodes.edit') . '</a>
        </li><li>' . delete_form(
            route('reactor.contents.destroy', $node->getKey()),
            trans('nodes.delete')
        ) .'</li>' . content_options_close() . '</div>';

        return $list;
    }
}