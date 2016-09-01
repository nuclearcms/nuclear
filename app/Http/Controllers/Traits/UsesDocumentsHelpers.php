<?php

namespace Reactor\Http\Controllers\Traits;


use Exception;
use Illuminate\Database\Eloquent\Collection;
use Kenarkose\Transit\Facade\Uploader;
use Nuclear\Documents\Media\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait UsesDocumentsHelpers {

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
            return response()->json([
                'type'    => 'error',
                'message' => $this->determineErrorMessage($e)
            ]);
        }

        // Let's reload the model if it is an image
        if ($media->type === 'image')
        {
            $media = Image::findOrFail($media->getKey());
        }

        $this->notify(null, 'created_media', $media);

        $upload = $media->toArray();
        $upload['summary'] = $media->summarize();
        $upload['edit_url'] = route('reactor.documents.edit', $media->getKey());

        return response()->json([
            'type'   => 'success',
            'upload' => $upload
        ]);
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
     * Prepares the list of given resources for json response
     *
     * @param Collection $documents
     * @return array
     */
    protected function summarizeDocuments(Collection $documents)
    {
        return array_map(function ($document)
        {
            return $document->summarize();
        }, $documents->all());
    }

}