<?php

namespace Reactor\Http\Builders;


use Illuminate\Support\ViewErrorBag;

class FormsHtmlBuilder {

    /**
     * Creates a button
     *
     * @param string $icon
     * @param string $text
     * @param string $type
     * @param string $class
     * @return string
     */
    public function button($icon, $text = '', $type = 'button', $class = '')
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

    /**
     * Snippet for generating a submit button
     *
     * @param string $icon
     * @param string $text
     * @param string $class
     * @return string
     */
    public function submitButton($icon, $text = '', $class = '')
    {
        return $this->button($icon, $text, 'submit', $class);
    }

    /**
     * Snippet for generating an action button
     *
     * @param string $link
     * @param string $icon
     * @param bool $secondary
     * @param string|null $text
     * @return string
     */
    public function actionButton($link, $icon, $secondary = false, $text = null)
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

    /**
     * Returns wrapper opening
     *
     * @param array $options
     * @param string $name
     * @param ViewErrorBag $errors
     * @param string $class
     * @return string
     */
    public function fieldWrapperOpen(array $options, $name, ViewErrorBag $errors, $class = '')
    {
        return sprintf(
            '<div class="form-group form-group-content %s %s %s" %s>',
            $errors->has($name) ? 'error' : '',
            (isset($options['inline']) and $options['inline']) ? 'inline' : '',
            $class,
            $options['wrapperAttrs']
        );
    }

    /**
     * Returns field wrapper closing
     *
     * @param array $options
     * @return string
     */
    public function fieldWrapperClose(array $options)
    {
        return ($options['wrapper'] !== false) ? '</div>' : '';
    }

    /**
     * Returns field label
     *
     * @param bool $showLabel
     * @param array $options
     * @param string $name
     * @return string
     */
    public function fieldLabel($showLabel, array $options, $name)
    {
        if ($showLabel && $options['label'] !== false)
        {
            return \Form::label($name,
                trans()->has('validation.attributes.' . $name) ?
                    trans('validation.attributes.' . $name) :
                    trans($options['label']),
                $options['label_attr']);
        }

        return '';
    }

    /**
     * Returns errors for the field
     *
     * @param ViewErrorBag $errors
     * @param string $name
     * @return string
     */
    public function fieldErrors(ViewErrorBag $errors, $name)
    {
        $html = '<ul class="form-group-errors">';

        foreach ($errors->get($name) as $error)
        {
            $html .= '<li>' . $error . '</li>';
        }

        return $html .= '</ul>';
    }

    /**
     * Creates a field help block
     *
     * @param string $name
     * @param array $options
     * @return string
     */
    public function fieldHelpBlock($name, array $options)
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

    /**
     * Snippet for for outputting html for delete forms
     *
     * @param string $action
     * @param string $text
     * @param string $input
     * @param string $icon
     * @return string
     */
    public function deleteForm($action, $text, $input = '', $icon = 'icon-trash')
    {
        return sprintf('<form action="%s" method="POST">' .
            method_field('DELETE') . csrf_field() .
            '%s<button type="submit" class="option-delete">
                <i class="%s"></i> %s
            </button></form>',
            $action, $input, $icon, $text);
    }

}