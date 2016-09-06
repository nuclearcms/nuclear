<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Nuclear\Hierarchy\Mailings\MailingList;

trait ModifiesMailingLists {

    /**
     * List the specified resource lists.
     *
     * @param int $id
     * @return Response
     */
    public function lists($id)
    {
        extract($this->getResourceNames());

        $model = $modelPath::with('lists')->findOrFail($id);

        list($form, $count) = $this->getAddListForm($id, $model, $resourceMultiple);

        $parameters = compact('form', 'count');
        $parameters[$resourceSingular] = $model;

        return $this->compileView($resourceMultiple . '.lists', $parameters, trans('mailing_lists.title'));
    }

    /**
     * Creates a form for associating lists
     *
     * @param int $id
     * @param Model $model
     * @param string $resourceMultiple
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getAddListForm($id, Model $model, $resourceMultiple)
    {
        $form = $this->form('Reactor\Html\Forms\MailingLists\AddMailingListForm', [
            'url' => route('reactor.' . $resourceMultiple . '.lists.associate', $id)
        ]);

        $choices = MailingList::all()
            ->diff($model->lists)
            ->pluck('name', 'id')
            ->toArray();

        $form->modify('list', 'select', [
            'choices' => $choices
        ]);

        return [$form, count($choices)];
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
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $this->validateForm('Reactor\Html\Forms\MailingLists\AddMailingListForm', $request);

        $model = $modelPath::findOrFail($id);

        $model->associateList($request->input('list'));

        $this->notify('mailing_lists.associated', 'associated_mailing_list', $model);

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
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $model = $modelPath::findOrFail($id);

        $model->dissociateList($request->input('list'));

        $this->notify('mailing_lists.dissociated', 'dissociated_mailing_list', $model);

        return redirect()->back();
    }

}