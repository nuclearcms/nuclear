<?php


namespace Reactor\Http\Controllers;


use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesMailingListForms;
use Reactor\Mailings\MailingList;

class MailingListsController extends ReactorController {

    use BasicResource, UsesMailingListForms;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = MailingList::class;
    protected $resourceMultiple = 'mailing_lists';
    protected $resourceSingular = 'mailing_list';
    protected $permissionKey = 'MAILINGLISTS';


}