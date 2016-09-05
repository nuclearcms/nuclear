<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Reactor\Mailings\MailingList;

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

    /**
     * @param int $id
     * @param MailingList $mailing_list
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditForm($id, MailingList $mailing_list)
    {
        return $this->form('Reactor\Html\Forms\MailingLists\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.mailing_lists.update', $id),
            'model' => $mailing_list
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateEditForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\MailingLists\CreateEditForm', $request);
    }

}