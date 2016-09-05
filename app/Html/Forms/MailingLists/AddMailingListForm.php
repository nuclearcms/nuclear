<?php


namespace Reactor\Html\Forms\MailingLists;


use Kris\LaravelFormBuilder\Form;

class AddMailingListForm extends Form  {

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
        $this->add('list', 'select', [
            'rules' => 'required'
        ]);
    }

}