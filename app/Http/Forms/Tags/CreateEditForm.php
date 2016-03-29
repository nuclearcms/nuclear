<?php

namespace Reactor\Http\Forms\Tags;


use Kris\LaravelFormBuilder\Form;

class CreateEditForm extends Form {

    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules'      => ['required', 'max:255', 'unique:tag_translations,name'],
            'help_block' => ['text' => trans('hints.tags_name')]
        ]);
    }

}