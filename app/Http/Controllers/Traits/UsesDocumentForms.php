<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;

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

}