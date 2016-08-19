<?php

namespace Reactor\Http\Controllers\Traits;


use Exception;
use Kenarkose\Transit\Facade\Uploader;
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

        $this->notify(null, 'created_media', $media);

        $upload = $media->toArray();
        $upload['edit_url'] = route('reactor.documents.edit', $media->getKey());

        return response()->json([
            'type' =>'success',
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

}