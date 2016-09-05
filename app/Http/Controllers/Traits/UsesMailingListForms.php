<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait UsesMailingListForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm()
    {
        return $this->form('Reactor\Html\Forms\MailingLists\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.mailing_lists.store')
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateCreateForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\MailingLists\CreateEditForm', $request);
    }

}