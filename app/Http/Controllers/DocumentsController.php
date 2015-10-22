<?php

namespace Reactor\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Kenarkose\Transit\Facade\Uploader;
use Reactor\Documents\Media;
use Reactor\Http\Requests;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocumentsController extends ReactorController {

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
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $documents = Media::search($request->input('q'))->get();

        return view('documents.search')
            ->with(compact('documents'));
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
     * Tries to upload a document
     *
     * @param UploadedFile $file
     * @return Document
     * @throws Exception
     */
    protected function uploadDocument(UploadedFile $file)
    {
        try
        {
            $media = Uploader::upload($file);
        } catch (Exception $e)
        {
            $response = $this->determineErrorMessage($e);

            return $this->makeUploadResponse('error', $response);
        }

        return $this->makeUploadResponse('success',
            $media->uploadResponse());
    }

    /**
     * Determines the validation error type
     *
     * @param Exception $e
     * @return string
     */
    protected function determineErrorMessage(Exception $e)
    {
        $exceptionType = class_basename($e);

        return trans('documents.' . $exceptionType);
    }

    /**
     * Prepares the uploaded file response
     *
     * @param string $type
     * @param mixed $response
     * @return array
     */
    protected function makeUploadResponse($type, $response)
    {
        return compact('type', 'response');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('ACCESS_DOCUMENTS_EDIT');

        $media = Media::findOrFail($id);

        $form = $this->form('Documents\EditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.documents.update', $id),
            'model' => $media
        ]);

        $form->modify('public_url', 'text',
            ['default_value' => $media->getPublicURL()]);
        $form->modify('absolute_path', 'text',
            ['default_value' => $media->getFilePath()]);

        return view('documents.edit', compact('form', 'media'));
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

        $this->validateForm('Documents\EditForm', $request);

        $media->update($request->all());

        flash()->success(trans('documents.edited'));

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

        flash()->success(trans('documents.deleted'));

        return redirect()->route('reactor.documents.index');
    }

    /**
     * Show the form for embedding external resource
     *
     * @return Response
     */
    public function embed()
    {

    }

    /**
     * Store the embedded external resource
     *
     * @param Request $request
     * @return Response
     */
    public function storeEmbedded(Request $request)
    {

    }

    /**
     * Show the form for editing images
     *
     * @param int $id
     * @return Response
     */
    public function image($id)
    {

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

    }
}
