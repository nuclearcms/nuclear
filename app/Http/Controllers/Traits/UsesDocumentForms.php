<?php

namespace Reactor\Http\Controllers\Traits;


use Reactor\Documents\Media;

trait UsesDocumentForms {

    /**
     * @param Media $media
     * @param string $locale
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getMediaTranslationsForm(Media $media, $locale)
    {
        return $this->form('Reactor\Http\Forms\Documents\EditMediaTranslationsForm', [
            'model' => $media->translateOrNew($locale)
        ]);
    }

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEmbedMediaForm()
    {
        return $this->form('Reactor\Http\Forms\Documents\EmbedForm', [
            'url' => route('reactor.documents.embed.store')
        ]);
    }

    /**
     * @param int $id
     * @param Media $media
     * @param string $locale
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditMediaForm($id, Media $media, $locale)
    {
        $form = $this->form('Reactor\Http\Forms\Documents\EditForm', [
            'url'   => route('reactor.documents.update', $id),
            'model' => array_merge($media->toArray(), $media->translateOrNew($locale)->toArray())
        ]);

        $form->modify('public_url', 'text',
            ['default_value' => $media->getPublicURL()]);

        return $form;
    }

    /**
     * @param int $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditImageForm($id)
    {
        return $this->form('Reactor\Http\Forms\Documents\ImageForm', [
            'url' => route('reactor.documents.image.update', $id),
        ]);
    }

}