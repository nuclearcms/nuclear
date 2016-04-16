<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Documents\Media;
use Reactor\Http\Controllers\Traits\UsesDocumentForms;
use Reactor\Http\Controllers\Traits\UsesDocumentHelpers;
use Reactor\Http\Requests;

class DocumentsController extends ReactorController {

    use UsesDocumentForms, UsesDocumentHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Media::sortable()->paginate(30);

        return view('documents.index', compact('documents'));
    }

    /**
     * Returns a json list of resources
     *
     * @param Request $request
     * @return json
     */
    public function jsonIndex(Request $request)
    {
        $offset = $request->input('offset', 0);

        $documents = Media::sortable('created_at', 'desc')
            ->take(30)->skip($offset)->get()->toArray();

        $remaining = Media::count() - ($offset + 30);

        return response()->json([
            'remaining' => $remaining,
            'media' => $documents
        ]);
    }

    /**
     * Retrieves json list of resources with given ids
     *
     * @param Request $request
     * @return $json
     */
    public function jsonRetrieve(Request $request)
    {
        $ids = $request->input('ids');

        $documents = empty($ids) ? [] :
            Media::find(json_decode($ids))->toArray();

        return response()->json($documents);
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $documents = Media::search($request->input('q'), 20, true)->get();

        return view('documents.search')
            ->with(compact('documents'));
    }

    /**
     * Returns a json list of search results
     *
     * @param Request $request
     * @return Response
     */
    public function jsonSearch(Request $request)
    {
        $documents = Media::search($request->input('q'), 20, true)
            ->limit(30)->get();

        return response()->json([
            'ids' => $documents->pluck('id'),
            'items' => $documents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $this->authorize('ACCESS_DOCUMENTS_UPLOAD');

        return view('documents.upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('ACCESS_DOCUMENTS_UPLOAD');

        return $this->uploadDocument($request->file('file'));
    }

    /**
     * Show the form for embedding external resource
     *
     * @return Response
     */
    public function embed()
    {
        $this->authorize('ACCESS_DOCUMENTS_EMBED');

        $form = $this->getEmbedMediaForm();

        return view('documents.embed', compact('form'));
    }

    /**
     * Store the embedded external resource
     *
     * @param Request $request
     * @return Response
     */
    public function storeEmbedded(Request $request)
    {
        $this->authorize('ACCESS_DOCUMENTS_EMBED');

        $this->validateForm('Reactor\Http\Forms\Documents\EmbedForm', $request);

        $media = Media::create($request->all());

        $this->notify('documents.embedded', 'embedded_media', $media);

        return redirect()->route('reactor.documents.edit', $media->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('ACCESS_DOCUMENTS_EDIT');

        $media = Media::findOrFail($id);

        $locale = $this->determineMediaLocale($request);

        $form = $this->getEditMediaForm($id, $media, $locale);

        return view('documents.edit', compact('form', 'media', 'locale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('ACCESS_DOCUMENTS_EDIT');

        $media = Media::findOrFail($id);

        $this->validateForm('Reactor\Http\Forms\Documents\EditForm', $request);

        $attributes = $this->compileUpdateAttributes($request, $media);

        $media->update($attributes);

        $this->notify('documents.edited', 'updated_media', $media);

        return redirect()->back();
    }

    /**
     * Show the form for editing images
     *
     * @param int $id
     * @return Response
     */
    public function image($id)
    {
        $this->authorize('ACCESS_DOCUMENTS_EDIT');

        $media = Media::whereType('image')->findOrFail($id);

        $form = $this->getEditImageForm($id);

        return view('documents.image', compact('media', 'form'));
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
        $this->authorize('ACCESS_DOCUMENTS_EDIT');

        $media = Media::findOrFail($id);

        $this->validateForm('Reactor\Http\Forms\Documents\ImageForm', $request);

        $media->editImage($request->input('action'));

        $this->notify('documents.edited_image', 'edited_image', $media);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('ACCESS_DOCUMENTS_DELETE');

        $media = Media::findOrFail($id);

        $media->delete();

        $this->notify('documents.deleted', 'deleted_media', $media);

        return redirect()->route('reactor.documents.index');
    }

}
