<?php

namespace Reactor\Html\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class EmbedForm extends Form {

    /**
     * Form options
     *
     * @var array
     */
    protected $formOptions = [
        'method' => 'POST'
    ];

    public function buildForm()
    {
        $this->add('path', 'text', [
            'rules' => ['required', 'url', 'regex:#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i'],
            'label' => 'documents.embed_identifier',
            'help_block' => ['text' => trans('hints.documents_embed')]
        ]);
    }

}
