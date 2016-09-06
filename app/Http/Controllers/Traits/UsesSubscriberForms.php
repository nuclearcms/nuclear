<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\Mailings\Subscriber;

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

}