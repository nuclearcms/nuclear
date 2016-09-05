<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesSubscriberForms;
use Reactor\Mailings\Subscriber;

class SubscribersController extends ReactorController {

    use BasicResource, UsesSubscriberForms;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = Subscriber::class;
    protected $resourceMultiple = 'subscribers';
    protected $resourceSingular = 'subscriber';
    protected $permissionKey = 'SUBSCRIBERS';

    /**
     * List the specified resource lists.
     *
     * @param int $id
     * @return Response
     */
    public function lists($id)
    {
        $subscriber = Subscriber::with('lists')->findOrFail($id);

        list($form, $count) = $this->getAddListForm($id, $subscriber);

        return $this->compileView('subscribers.lists', compact('subscriber', 'form', 'count'), trans('mailing_lists.title'));
    }

    /**
     * Add a list to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function associateList(Request $request, $id)
    {
        $this->authorize('EDIT_MAILINGLISTS');

        $this->validateForm('Reactor\Html\Forms\MailingLists\AddMailingListForm', $request);

        $subscriber = Subscriber::findOrFail($id);

        $subscriber->associateList($request->input('list'));

        $this->notify('mailing_lists.associated', 'associated_list_to_subscriber', $subscriber);

        return redirect()->back();
    }

    /**
     * Remove an list from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function dissociateList(Request $request, $id)
    {
        $this->authorize('EDIT_MAILINGLISTS');

        $subscriber = Subscriber::findOrFail($id);

        $subscriber->dissociateList($request->input('list'));

        $this->notify('mailing_lists.dissociated', 'dissociated_list_from_subscriber', $subscriber);

        return redirect()->route('reactor.subscribers.lists', $id);
    }

}