<?php


namespace Reactor\Http\Controllers;


use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesMailingListForms;
use Nuclear\Hierarchy\Mailings\MailingList;

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

    /**
     * List the specified resource fields.
     *
     * @param int $id
     * @return Response
     */
    public function mailings($id)
    {
        $mailing_list = MailingList::findOrFail($id);

        $mailings = $mailing_list->mailings()
            ->sortable()->paginate();

        return $this->compileView('mailing_lists.mailings', compact('mailing_list', 'mailings'), trans('mailings.title'));
    }

}