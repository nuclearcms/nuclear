<?php

if ( ! function_exists('activity_open'))
{
    /**
     * Returns an activity opening tag
     *
     * @param Activity $activity
     * @param bool $minor
     * @return string
     */
    function activity_open($activity, $minor = true)
    {
        return app('reactor.builders.activities')->activityOpen($activity, $minor);
    }
}

if ( ! function_exists('activity_close'))
{
    /**
     * Returns an activity closing tag
     *
     * @return string
     */
    function activity_close()
    {
        return app('reactor.builders.activities')->activityClose();
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
        return app('reactor.builders.contents')->contentTableOpen($sub, $wrapper);
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
        return app('reactor.builders.contents')->contentTableMiddle();
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
        return app('reactor.builders.contents')->contentTableClose($sub, $wrapper);
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
        return app('reactor.builders.contents')->contentOptionsOpen($header, $table);
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
        return app('reactor.builders.contents')->contentOptionsClose($table);
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
        return app('reactor.builders.contents')->noResultsRow($message);
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
        return app('reactor.builders.contents')->backToAllLink($link, $text);
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
        return app('reactor.builders.forms')->button($icon, $text, $type, $class);
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
        return app('reactor.builders.forms')->submitButton($icon, $text, $class);
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
        return app('reactor.builders.forms')->actionButton($link, $icon, $secondary, $text);
    }
}

if ( ! function_exists('field_wrapper_open'))
{
    /**
     * Returns wrapper opening
     *
     * @param array $options
     * @param string $name
     * @param ViewErrorBag $errors
     * @param string $class
     * @return string
     */
    function field_wrapper_open(array $options, $name, $errors, $class = '')
    {
        return app('reactor.builders.forms')->fieldWrapperOpen($options, $name, $errors, $class);
    }
}

if ( ! function_exists('field_wrapper_close'))
{
    /**
     * Returns field wrapper closing
     *
     * @param array $options
     * @return string
     */
    function field_wrapper_close(array $options)
    {
        return app('reactor.builders.forms')->fieldWrapperClose($options);
    }
}

if ( ! function_exists('field_label'))
{
    /**
     * Returns field label
     *
     * @param bool $showLabel
     * @param array $options
     * @param string $name
     * @return string
     */
    function field_label($showLabel, array $options, $name)
    {
        return app('reactor.builders.forms')->fieldLabel($showLabel, $options, $name);
    }
}

if ( ! function_exists('field_errors'))
{
    /**
     * Returns errors for the field
     *
     * @param ViewErrorBag $errors
     * @param string $name
     * @return string
     */
    function field_errors($errors, $name)
    {
        return app('reactor.builders.forms')->fieldErrors($errors, $name);
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
        return app('reactor.builders.forms')->fieldHelpBlock($name, $options);
    }
}

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
        return app('reactor.builders.forms')->deleteForm($action, $text, $input, $icon);
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
        return app('reactor.builders.navigation')->navigationModuleOpen($icon, $title);
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
        return app('reactor.builders.navigation')->navigationModuleClose();
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
        return app('reactor.builders.navigation')->navigationModuleLink($route, $icon, $title, $parameters);
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
        return app('reactor.builders.nodes')->ancestorLinks($ancestors);
    }
}

if ( ! function_exists('node_options_list'))
{
    /**
     * Snippet for generating node options
     *
     * @param Node $node
     * @return string
     */
    function node_options_list($node)
    {
        return app('reactor.builders.nodes')->nodeOptionsList($node);
    }
}

if ( ! function_exists('node_option_form'))
{
    /**
     * Snippet for for outputting html for delete forms
     *
     * @param string $action
     * @param string $icon
     * @param string $text
     * @return string
     */
    function node_option_form($action, $icon, $text)
    {
        return app('reactor.builders.nodes')->nodeOptionForm($action, $icon, $text);
    }
}