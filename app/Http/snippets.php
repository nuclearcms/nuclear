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
     * @param bool $table
     * @return string
     */
    function content_options_open($header = null, $table = true)
    {
        return sprintf('%s
            <button class="content-item-options-button">
                <i class="icon-ellipsis-vert"></i>
            </button>
            <ul class="content-item-options-list material-middle">%s',
            $table ? '<td class="content-item-options">' : '',
            $header ?: '<li class="list-header">' . uppercase(trans('general.options')) . '</li>');
    }
}

if ( ! function_exists('content_options_close'))
{
    /**
     * Snippet for displaying content options closing
     *
     * @param bool $table
     * @return string
     */
    function content_options_close($table = true)
    {
        return '</ul>' . ($table) ? '</td>' : '';
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
     * @param string $class
     * @return string
     */
    function submit_button($icon, $text = '', $class = '')
    {
        return button($icon, $text, 'submit', $class);
    }

}

if ( ! function_exists('button'))
{
    /**
     * Creates a button
     *
     * @param string $icon
     * @param string $text
     * @param string $type
     * @param string $class
     * @return string
     */
    function button($icon, $text = '', $type = 'button', $class = '')
    {
        $iconType = empty($text) ? 'button-icon-primary' : 'button-icon';

        return sprintf('<button class="button button-emphasized %s %s" type="%s">
            %s <i class="%s"></i>
        </button>',
            $iconType,
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
                '</li>', false
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
            ) . '</li>' . content_options_close(false) . '</div>';

        return $list;
    }
}

if ( ! function_exists('ancestor_links'))
{
    /**
     * Makes an array of ancestor links
     *
     * @param Collection
     * @return array
     */
    function ancestor_links($ancestors)
    {
        $links = [];

        foreach ($ancestors as $ancestor)
        {
            $links[] = link_to_route('reactor.contents.edit', $ancestor->title, $ancestor->getKey());
        }

        return $links;
    }
}

if ( ! function_exists('field_help_block'))
{
    /**
     * Creates a field help block
     *
     * @param string $name
     * @param array $options
     * @return string
     */
    function field_help_block($name, array $options)
    {
        $html = '<div class="form-group-column form-group-column-help">';

        if ( ! empty($options['help_block']['text']))
        {
            $html .= trans($options['help_block']['text']);
        } else
        {
            if (trans()->has('hints.' . $name))
            {
                $html .= trans('hints.' . $name);
            }
        }

        return $html . '</div>';
    }
}

if ( ! function_exists('field_label'))
{
    /**
     * Renders field label
     *
     * @param bool $showLabel
     * @param array $options
     * @param string $name
     * @return string
     */
    function field_label($showLabel, array $options, $name)
    {
        if ($showLabel && $options['label'] !== false)
        {
            return Form::label($name,
                trans()->has('validation.attributes.' . $name) ?
                    trans('validation.attributes.' . $name) :
                    trans($options['label']),
                $options['label_attr']);
        }

        return '';
    }
}

if ( ! function_exists('field_errors'))
{
    /**
     * Renders errors for the field
     *
     * @param $errors
     * @param string $name
     * @return string
     */
    function field_errors($errors, $name)
    {
        $html = '<ul class="form-group-errors">';

        foreach ($errors->get($name) as $error)
        {
            $html .= '<li>' . $error . '</li>';
        }

        return $html .= '</ul>';
    }
}

if ( ! function_exists('field_wrapper_open'))
{
    /**
     * Renders wrapper opening
     *
     * @param array $options
     * @param string $name
     * @param $errors
     * @param string $class
     * @return string
     */
    function field_wrapper_open(array $options, $name, $errors, $class = '')
    {
        return sprintf(
            '<div class="form-group form-group-content %s %s %s" %s>',
            $errors->has($name) ? 'error' : '',
            (isset($options['inline']) and $options['inline']) ? 'inline' : '',
            $class,
            $options['wrapperAttrs']
        );
    }
}

if ( ! function_exists('field_wrapper_close'))
{
    /**
     * Renders field wrapper closing
     *
     * @param array $options
     * @return string
     */
    function field_wrapper_close(array $options)
    {
        return ($options['wrapper'] !== false) ? '</div>' : '';
    }
}

if ( ! function_exists('activity_open'))
{
    /**
     * Renders an activity opening tag
     *
     * @param Model $activity
     * @param bool $minor
     * @return string
     */
    function activity_open($activity, $minor = true)
    {
        if ($minor)
        {
            $html = '<li class="activity activity-minor">';
        } else
        {
            $html = '<li class="activity">
                <div class="activity-actor"><span class="user-frame">' .
                $activity->user->present()->avatar .
                '</span></div>';
        }

        return $html .= '<div class="activity-subject">
            <span class="time">' . $activity->created_at->diffForHumans() . '</span>
                <p class="subject">';
    }
}

if ( ! function_exists('activity_close'))
{
    /**
     * Renders an activity closing tag
     *
     * @return string
     */
    function activity_close()
    {
        return '</p></div></li>';
    }
}