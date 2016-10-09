<?php


namespace Reactor\Html\Forms\MailingLists;


use Kris\LaravelFormBuilder\Form;

class CreateEditForm extends Form {

    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => 'required|max:255'
        ]);

        $this->add('type', 'select', [
            'rules' => 'required',
            'choices' => [
                'default' => trans('general.default'),
                'mailchimp' => 'Mailchimp'
            ],
            'help_block' => ['text' => trans('hints.mailing_lists_type')]
        ]);

        $this->add('from_name', 'text', [
            'help_block' => ['text' => trans('hints.mailing_lists_from_name')]
        ]);
        $this->add('reply_to', 'text', [
            'help_block' => ['text' => trans('hints.mailing_lists_reply_to')]
        ]);
        $this->add('options', 'textarea', [
            'rules' => 'json',
            'help_block' => ['text' => trans('hints.mailing_lists_options')]
        ]);
        $this->add('external_id', 'text', [
            'help_block' => ['text' => trans('hints.mailing_lists_external_id')]
        ]);
    }

}