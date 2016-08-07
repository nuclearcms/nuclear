<?php

use Illuminate\Support\ViewErrorBag;

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
