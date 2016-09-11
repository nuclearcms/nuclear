<?php


namespace Reactor\Http\Controllers;


use igaster\laravelTheme\Facades\Theme;
use Illuminate\Http\Request;
use Nuclear\Hierarchy\MailingNode;
use Nuclear\Hierarchy\Mailings\MailingList;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\DispatchesMailings;
use Reactor\Http\Controllers\Traits\ModifiesMailingLists;
use Reactor\Http\Controllers\Traits\UsesMailingForms;
use Reactor\Http\Controllers\Traits\UsesMailingHelpers;
use Reactor\Http\Controllers\Traits\UsesTranslations;

class MailingsController extends ReactorController {

    use UsesMailingForms, UsesMailingHelpers, UsesTranslations, BasicResource,
        ModifiesMailingLists, DispatchesMailings;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = MailingNode::class;
    protected $resourceMultiple = 'mailings';
    protected $resourceSingular = 'mailing';
    protected $permissionKey = 'MAILINGS';

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        // Because of the searchable trait we are adding the global scopes from scratch
        $mailings = MailingNode::withoutGlobalScopes()
            ->typeMailing()
            ->groupBy('id')
            // Search should be the last
            ->search($request->input('q'), 20, true)
            ->get();

        return $this->compileView('mailings.search', compact('mailings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('EDIT_MAILINGS');

        $this->validateCreateForm($request);

        $mailing = $this->createMailing($request);

        $this->notify('mailings.created');

        return redirect()->route('reactor.mailings.edit', $mailing->getKey());
    }

    /**
     * Show the form for editing the specified resources translation.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->editTranslated($id, null);
    }

    /**
     * Update the specified resources translation in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->updateTranslated($request, $id, null);
    }

    /**
     * Determines the current editing locale
     *
     * @param int $translation
     * @param MailingNode $mailing
     * @return string
     */
    protected function determineLocaleAndTranslation($translation, MailingNode $mailing)
    {
        $translation = $mailing->translateOrFirst();

        if (is_null($translation))
        {
            abort(404);
        }

        return [$translation->locale, $translation];
    }

    /**
     * Show the page for resource transformation options
     *
     * @param int $id
     * @return Response
     */
    public function transform($id)
    {
        $this->authorize('EDIT_MAILINGS');

        $mailing = MailingNode::findOrFail($id);

        $form = $this->getTransformForm($id, $mailing);

        return $this->compileView('mailings.transform', compact('mailing', 'form'));
    }

    /**
     * Transforms the resource into given type
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function transformPut(Request $request, $id)
    {
        $this->authorize('EDIT_MAILINGS');

        $mailing = MailingNode::findOrFail($id);

        $this->validateTransformForm($request);

        // Recording paused for this, otherwise two records are registered
        chronicle()->pauseRecording();
        $mailing->transformInto($request->input('type'));
        // and resume
        chronicle()->resumeRecording();

        $this->notify('mailings.transformed', 'transformed_mailing', $mailing);

        return redirect()->route('reactor.mailings.edit', $id);
    }

    /**
     * Previews the resource
     *
     * @param string $name
     * @return view
     */
    public function preview($name)
    {
        $mailing = MailingNode::withName($name)->firstOrFail();
        $translation = $mailing->translateOrFirst();
        $_inBrowser = true;

        return view($mailing->getNodeTypeName(), compact('mailing', 'translation', '_inBrowser'));
    }

    /**
     * Dispatches the mailing
     *
     * @param int $id
     * @param int $list
     * @return response
     */
    public function dispatchMailing($id, $list)
    {
        $this->authorize('EDIT_MAILINGS');

        $mailing = MailingNode::findOrFail($id);
        $list = MailingList::findOrFail($list);

        // Before this we are in the reactor theme by default
        Theme::set(config('themes.active_mailings'));

        if($list->type === 'mailchimp')
        {
            $this->dispatchMailchimpMailing($mailing, $list);
        } else {
            $this->dispatchDefaultMailing($mailing, $list);
        }

        $this->notify('mailings.dispatched', 'dispatched_mailing', $mailing);

        return redirect()->back();
    }

}