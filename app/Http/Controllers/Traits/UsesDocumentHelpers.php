<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Kenarkose\Transit\Facade\Uploader;
use Reactor\Documents\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait UsesDocumentHelpers {

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

        $this->notify(null, 'created_media', $media);

        return $this->makeUploadResponse('success',
            $media->toArray());
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
     * @param Request $request
     * @param Media $media
     * @return array
     */
    protected function compileUpdateAttributes(Request $request, Media $media)
    {
        $locale = $request->get('locale');
        $attributes = $media->translatedAttributes;

        return array_merge(
            $request->except(array_merge($attributes, ['locale'])),
            [$locale => $request->only($attributes)]
        );
    }

    /**
     * Determines the locale for media request
     *
     * @param Request $request
     * @return mixed|null
     */
    protected function determineMediaLocale(Request $request)
    {
        $locale = $request->get('locale', config('app.locale'));

        if ( ! in_array($locale, config('translatable.locales')))
        {
            $locale = config('app.locale');
        }

        return $locale;
    }

}