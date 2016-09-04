<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\MailingNode;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesMailingForms;
use Reactor\Http\Controllers\Traits\UsesMailingHelpers;
use Reactor\Http\Controllers\Traits\UsesTranslations;

class MailingsController extends ReactorController {

    use UsesMailingForms, UsesMailingHelpers, UsesTranslations, BasicResource;

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

}