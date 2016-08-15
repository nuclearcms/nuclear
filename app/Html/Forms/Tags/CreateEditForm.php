<?php

namespace Reactor\Html\Forms\Tags;


use Kris\LaravelFormBuilder\Form;

class CreateEditForm extends Form {

    public function buildForm()
    {
        $this->add('title', 'text', [
            'rules'      => ['required', 'max:255', 'unique:tag_translations,title'],
            'help_block' => ['text' => trans('hints.tags_title')]
        ]);
        $this->add('tag_name', 'slug', [
            'rules' => 'max:255|alpha_dash|unique:tag_translations,tag_name',
            'help_block' => ['text' => trans('hints.slug')]
        ]);
    }

}