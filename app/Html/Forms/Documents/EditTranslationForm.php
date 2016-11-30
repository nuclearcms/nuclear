<?php


namespace Reactor\Html\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class EditTranslationForm extends Form {

    public function buildForm()
    {
        $this->add('caption', 'text', [
            'label' => trans('validation.attributes.caption'),
            'help_block' => ['text' => trans('hints.documents_caption')]
        ]);
        $this->add('description', 'textarea', [
            'label' => trans('validation.attributes.description')
        ]);
        $this->add('alttext', 'text', [
            'label' => trans('validation.attributes.alttext'),
            'help_block' => ['text' => trans('hints.documents_alttext')]
        ]);
    }

}