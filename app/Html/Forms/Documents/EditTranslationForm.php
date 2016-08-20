<?php


namespace Reactor\Html\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class EditTranslationForm extends Form {

    public function buildForm()
    {
        $this->add('caption', 'text', [
            'help_block' => ['text' => trans('hints.documents_caption')]
        ]);
        $this->add('description', 'textarea');
        $this->add('alttext', 'text', [
            'help_block' => ['text' => trans('hints.documents_alttext')]
        ]);
    }

}