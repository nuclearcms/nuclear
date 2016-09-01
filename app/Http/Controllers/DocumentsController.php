<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Kenarkose\Transit\Facade\Downloader;
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

    /**
     * Show the form for editing images
     *
     * @param int $id
     * @return Response
     */
    public function image($id)
    {
        $this->authorize('EDIT_DOCUMENTS');

        $document = Media::whereType('image')->findOrFail($id);

        $form = $this->getEditImageForm($id);

        return $this->compileView('documents.edit_image', compact('document', 'form'));
    }

    /**
     * Update the specified image
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function imageUpdate(Request $request, $id)
    {
        $this->authorize('EDIT_DOCUMENTS');

        $image = Media::findOrFail($id);

        $this->validateEditImageForm($request);

        $image->editImage($request->input('action'));

        $this->notify('documents.edited_image', 'edited_image', $image);

        return redirect()->back();
    }

    /**
     * Show the form for editing images
     *
     * @param int $id
     * @return Response
     */
    public function download($id)
    {
        $document = Media::findOrFail($id);

        return Downloader::download($document);
    }

    /**
     * Returns a json list of search results
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        $documents = Media::search($request->input('q'), 20, true)
            ->limit(30)->get();

        $ids = $documents->pluck('id');
        $documents = $this->summarizeDocuments($documents);

        return response()->json(compact('documents', 'ids'));
    }

    /**
     * Returns a json list of resources
     *
     * @param Request $request
     * @return response
     */
    public function load(Request $request)
    {
        $offset = $request->input('offset', 0);

        $documents = Media::sortable('created_at', 'desc')
            ->take(30)->skip($offset)->get();

        $documents = $this->summarizeDocuments($documents);

        $remaining = Media::count() - ($offset + 30);

        return response()->json(compact('documents', 'remaining'));
    }

    /**
     * Retrieves json list of resources with given ids
     *
     * @param Request $request
     * @return response
     */
    public function retrieve(Request $request)
    {
        $ids = $request->input('ids');

        $documents = empty($ids) ? [] :
            Media::find(json_decode($ids));

        $documents = $this->summarizeDocuments($documents);

        return response()->json($documents);
    }

    /**
     * Updates a resources from a ajax request
     *
     * @param Request $request
     * @return response
     */
    public function updateJson(Request $request)
    {
        $this->authorize('EDIT_DOCUMENTS');

        $document = Media::findOrFail($request->input('document'));

        $document->update($request->all());

        return response()->json($document->summarize());
    }

}