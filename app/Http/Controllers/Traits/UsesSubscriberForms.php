<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Reactor\Mailings\MailingList;
use Reactor\Mailings\Subscriber;

trait UsesSubscriberForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm()
    {
        return $this->form('Reactor\Html\Forms\Subscribers\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.subscribers.store')
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateCreateForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Subscribers\CreateEditForm', $request);
    }

    /**
     * @param int $id
     * @param Subscriber $subscriber
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditForm($id, Subscriber $subscriber)
    {
        return $this->form('Reactor\Html\Forms\Subscribers\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.subscribers.update', $id),
            'model'  => $subscriber
        ]);
    }

    /**
     * @param Request $request
     * @param Subscriber $subscriber
     */
    protected function validateEditForm(Request $request, Subscriber $subscriber)
    {
        $this->validateForm('Reactor\Html\Forms\Subscribers\CreateEditForm', $request, [
            'email' => 'required|email|max:255|unique:subscribers,email,' . $subscriber->getKey()
        ]);
    }

    /**
     * Creates a form for adding permissions
     *
     * @param int $id
     * @param Subscriber $subscriber
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getAddListForm($id, Subscriber $subscriber)
    {
        $form = $this->form('Reactor\Html\Forms\MailingLists\AddMailingListForm', [
            'url' => route('reactor.subscribers.lists.associate', $id)
        ]);

        $choices = MailingList::all()
            ->diff($subscriber->lists)
            ->pluck('name', 'id')
            ->toArray();

        $form->modify('list', 'select', [
            'choices' => $choices
        ]);

        return [$form, count($choices)];
    }

}