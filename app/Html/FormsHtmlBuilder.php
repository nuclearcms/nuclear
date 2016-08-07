<?php

namespace Reactor\Html;


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
        $iconType = empty($text) ? '<i class="%s button__icon"></i>' :
            ($iconSide === 'r' ?
                '%s <i class="' . $icon . ' button__icon button__icon--right"></i>' :
                '<i class="' . $icon . ' button__icon button__icon--left"> %s</i>'
            );

        return sprintf('<button class="button %s" type="%s">' . $iconType . '</button>',
            $class,
            $type,
            uppercase(trans($text)));
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
        $iconType = empty($text) ? '<i class="%s button__icon"></i>' :
            ($iconSide === 'r' ?
                '%s <i class="' . $icon . ' button__icon button__icon--right"></i>' :
                '<i class="' . $icon . ' button__icon button__icon--left"> %s</i>'
            );

        return sprintf('<a href="%s" class="button %s">' . $iconType . '</a>',
            $link,
            $class,
            uppercase(trans($text)));
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
            $options['label_attr']['class'] = 'form-group__label ' . ($errors->has($name) ? ' form-group__label--error' : '') . $class;

            return \Form::label($name,
                (isset($options['label']) && !empty($options['label'])) ?
                    $options['label'] :
                    (trans()->has('validation.attributes.' . $name) ?
                        trans('validation.attributes.' . $name) :
                        $name),
                $options['label_attr']);
        }

        return '';
    }

}