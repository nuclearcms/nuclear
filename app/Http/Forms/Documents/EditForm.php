<?php

namespace Reactor\Http\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class EditForm extends Form {

    /**
     * Form options
     *
     * @var array
     */
    protected $formOptions = [
        'method' => 'PUT'
    ];

    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => 'required|max:255'
        ]);
        $this->add('public_url', 'text', [
            'attr' => ['disabled']
        ]);

        // Translated fields
        $this->add('caption', 'text', [
            'rules' => 'max:255'
        ]);
        $this->add('description', 'textarea');
        $this->add('locale', 'hidden', [
            'rules' => 'required|in:' . implode(',', config('translatable.locales'))
        ]);
    }

}