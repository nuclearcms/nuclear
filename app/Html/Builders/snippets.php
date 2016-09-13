<?php

use Illuminate\Support\ViewErrorBag;
use Nuclear\Hierarchy\Node;

if ( ! function_exists('activity_open'))
{
    /**
     * Returns an activity opening tag
     *
     * @param Activity $activity
     * @param bool $minor
     * @param string $thumbnail
     * @return string
     */
    function activity_open($activity, $minor = true, $thumbnail = '')
    {
        return app('reactor.builders.activities')->activityOpen($activity, $minor, $thumbnail);
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

if ( ! function_exists('content_list_thumbnail'))
{
    /**
     * Snippet for displaying the selection/thumbnail column
     *
     * @param int $id
     * @param string $thumbnail
     * @return string
     */
    function content_list_thumbnail($id, $thumbnail = '')
    {
        return app('reactor.builders.contents')->contentListThumbnail($id, $thumbnail);
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

if ( ! function_exists('content_options'))
{
    /**
     * Snippet for displaying standard content options
     *
     * @param string $key
     * @param int $id
     * @return string
     */
    function content_options($key, $id)
    {
        return app('reactor.builders.contents')->contentOptions($key, $id);
    }
}

if ( ! function_exists('header_action_open'))
{
    /**
     * Snippet for displaying header action opening
     *
     * @param string $text
     * @param string $class
     * @param bool $secondary
     * @return string
     */
    function header_action_open($text, $class = "header__action--left", $secondary = false)
    {
        return app('reactor.builders.contents')->headerActionOpen($text, $class, $secondary);
    }
}

if ( ! function_exists('header_action_close'))
{
    /**
     * Snippet for displaying header action closing
     *
     * @return string
     */
    function header_action_close()
    {
        return app('reactor.builders.contents')->headerActionClose();
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
     * @param string $key
     * @return string
     */
    function back_to_all_link($key)
    {
        return app('reactor.builders.contents')->backToAllLink($key);
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
     * @param string $iconSide
     * @return string
     */
    function button($icon, $text = '', $type = 'button', $class = 'button--emphasis', $iconSide = 'r')
    {
        return app('reactor.builders.forms')->button($icon, $text, $type, $class, $iconSide);
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
     * @param string $iconSide
     * @return string
     */
    function submit_button($icon, $text = '', $class = 'button--emphasis', $iconSide = 'r')
    {
        return app('reactor.builders.forms')->submitButton($icon, $text, $class, $iconSide);
    }

}

if ( ! function_exists('action_button'))
{
    /**
     * Snippet for generating an action button
     *
     * @param string $link
     * @param string $icon
     * @param string $text
     * @param string $class
     * @param string $iconSide
     * @return string
     */
    function action_button($link, $icon, $text = '', $class = 'button--emphasis', $iconSide = 'r')
    {
        return app('reactor.builders.forms')->actionButton($link, $icon, $text, $class, $iconSide);
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
    function field_wrapper_open(array $options, $name, ViewErrorBag $errors, $class = '')
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
     * @param ViewErrorBag $errors
     * @return string
     */
    function field_label($showLabel, array $options, $name, ViewErrorBag $errors)
    {
        return app('reactor.builders.forms')->fieldLabel($showLabel, $options, $name, $errors);
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
     * @param bool $specific
     * @param string $icon
     * @return string
     */
    function delete_form($action, $text, $input = '', $specific = false, $icon = 'icon-trash')
    {
        return app('reactor.builders.forms')->deleteForm($action, $text, $input, $specific, $icon);
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
     * @param Collection $ancestors
     * @return array
     */
    function ancestor_links($ancestors)
    {
        return app('reactor.builders.nodes')->ancestorLinks($ancestors);
    }
}

if ( ! function_exists('node_options'))
{
    /**
     * Snippet for displaying node default content options
     *
     * @param Node $node
     * @param string $header
     * @param bool $table
     * @return string
     */
    function node_options(Node $node, $header = null, $table = true)
    {
        return app('reactor.builders.nodes')->nodeOptions($node, $header, $table);
    }
}

if ( ! function_exists('tree_node_options'))
{
    /**
     * Snippet for displaying node default content options
     *
     * @param Node $node
     * @return string
     */
    function tree_node_options(Node $node)
    {
        return app('reactor.builders.nodes')->treeNodeOptions($node);
    }
}

if ( ! function_exists('node_option_form'))
{
    /**
     * Snippet for displaying node option forms
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
