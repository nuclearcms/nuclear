<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Documents\Media\EmbeddedMedia;
use Nuclear\Documents\Media\Media;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesDocumentForms;
use Reactor\Http\Controllers\Traits\UsesDocumentsHelpers;

class DocumentsController extends ReactorController {

    use BasicResource, UsesDocumentForms, UsesDocumentsHelpers;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = Media::class;
    protected $resourceMultiple = 'documents';
    protected $resourceSingular = 'document';
    protected $permissionKey = 'DOCUMENTS';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Media::sortable()
            ->filteredByType()->paginate();

        return $this->compileView('documents.index', compact('documents'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $documents = Media::search($request->input('q'), 20, true)
            ->filteredByType()->groupBy('id')->get();

        return $this->compileView('documents.search', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $this->authorize('EDIT_DOCUMENTS');

        return $this->compileView('documents.upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('EDIT_DOCUMENTS');

        return $this->uploadDocument($request->file('file'));
    }

    /**
     * Show the form for embedding external resource
     *
     * @return Response
     */
    public function embed()
    {
        $this->authorize('EDIT_DOCUMENTS');

        $form = $this->getEmbedForm();

        return $this->compileView('documents.embed', compact('form'));
    }

    /**
     * Store the embedded external resource
     *
     * @param Request $request
     * @return Response
     */
    public function storeEmbedded(Request $request)
    {
        $this->authorize('EDIT_DOCUMENTS');

        $this->validateEmbedForm($request);

        $media = EmbeddedMedia::create($request->all());

        $this->notify('documents.embedded', 'embedded_media', $media);

        return redirect()->route('reactor.documents.edit', $media->getKey());
    }

}