<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Documents\Media\Media;

trait UsesDocumentForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEmbedForm()
    {
        return $this->form('Reactor\Html\Forms\Documents\EmbedForm', [
            'url' => route('reactor.documents.embed.store')
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateEmbedForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Documents\EmbedForm', $request);
    }

    /**
     * @param int $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditImageForm($id)
    {
        return $this->form('Reactor\Html\Forms\Documents\ImageForm', [
            'url' => route('reactor.documents.image.update', $id)
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateEditImageForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Documents\ImageForm', $request);
    }

    /**
     * @param int $id
     * @param Media $document
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditForm($id, Media $document)
    {
        $attributes = [
            'name' => $document->name,
            'public_url' => $document->getPublicURL()
        ];

        foreach($document->translations as $translation)
        {
            $attributes[$translation->locale] = $translation->toArray();
        }

        return $this->form('Reactor\Html\Forms\Documents\EditForm', [
            'url' => route('reactor.documents.update', $id),
            'model' => $attributes
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateEditForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Documents\EditForm', $request);
    }

}