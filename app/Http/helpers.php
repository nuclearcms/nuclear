<?php

if ( ! function_exists('delete_form'))
{
    /**
     * Helper for for outputting html for delete forms
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