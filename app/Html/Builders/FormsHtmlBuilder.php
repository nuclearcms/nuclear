<?php

namespace Reactor\Html\Builders;


use Illuminate\Support\ViewErrorBag;

class FormsHtmlBuilder {

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
    public function button($icon, $text = '', $type = 'button', $class = 'button--emphasis', $iconSide = 'r')
    {
        $iconType = empty($text) ? '<i class="' . $icon . ' button__icon button__icon--action"></i>' :
            ($iconSide === 'r' ?
                uppercase($text) . ' <i class="' . $icon . ' button__icon button__icon--right"></i>' :
                '<i class="' . $icon . ' button__icon button__icon--left"></i> ' . uppercase($text)
            );

        return sprintf('<button class="button %s" type="%s">' . $iconType . '</button>',
            $class,
            $type);
    }

    /**
     * Snippet for generating a submit button
     *
     * @param string $icon
     * @param string $text
     * @param string $class
     * @param string $iconSide
     * @return string
     */
    public function submitButton($icon, $text = '', $class = 'button--emphasis', $iconSide = 'r')
    {
        return $this->button($icon, $text, 'submit', $class, $iconSide);
    }

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
    public function actionButton($link, $icon, $text = '', $class = 'button--emphasis', $iconSide = 'r')
    {
        $iconType = empty($text) ? '<i class="' . $icon . ' button__icon button__icon--action"></i>' :
            ($iconSide === 'r' ?
                uppercase($text) . ' <i class="' . $icon . ' button__icon button__icon--right"></i>' :
                '<i class="' . $icon . ' button__icon button__icon--left"></i> ' . uppercase($text)
            );

        return sprintf('<a href="%s" class="button %s">' . $iconType . '</a>',
            $link,
            $class);
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
            '<div class="form-group %s %s %s" %s>',
            $errors->has($name) ? 'form-group--error' : '',
            (isset($options['inline']) and $options['inline']) ? 'form-group--inline' : '',
            $class,
            isset($options['wrapperAttrs']) ? $options['wrapperAttrs'] : ''
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
     * @param ViewErrorBag $errors
     * @return string
     */
    public function fieldLabel($showLabel, array $options, $name, ViewErrorBag $errors)
    {
        if ($showLabel && !(isset($options['label']) && $options['label'] === false))
        {
            $class = isset($options['label_attr']['class']) ? $options['label_attr']['class'] : '';
            $options['label_attr']['class'] = 'form-group__label ' . ($errors->has($name) ? ' form-group__label--error ' : '') . $class;

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
        $html = '<ul class="form-group__errors">';

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
        $html = '<div class="form-group-column form-group-column--help">';

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
            '%s<button class="option-delete" type="submit">
                <i class="%s"></i>%s
            </button></form>',
            $action, $input, $icon, $text);
    }

}