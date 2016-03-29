<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Reactor\Tags\Tag;
use Reactor\Tags\TagTranslation;

trait UsesTagForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateTagForm()
    {
        return $this->form('Reactor\Http\Forms\Tags\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.tags.store')
        ]);
    }

    /**
     * @param int $id
     * @param TagTranslation $translation
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditTagForm($id, TagTranslation $translation)
    {
        return $this->form('Reactor\Http\Forms\Tags\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.tags.update', [$id, $translation->getKey()]),
            'model'  => $translation
        ]);
    }

    /**
     * @param Request $request
     * @param TagTranslation $translation
     */
    protected function validateUpdateTag(Request $request, TagTranslation $translation)
    {
        $this->validateForm('Reactor\Http\Forms\Tags\CreateEditForm', $request, [
            'name' => ['required', 'max:255',
                'unique:tag_translations,name,' . $translation->getKey()]
        ]);
    }

    /**
     * @param Tag $tag
     * @param array $locales
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateTagTranslationForm(Tag $tag, array $locales)
    {
        $form = $this->form('Reactor\Http\Forms\Tags\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.tags.translation.store', [$tag->getKey()])
        ]);

        $form->addBefore('name', 'locale', 'select', [
            'choices' => $locales
        ]);

        return $form;
    }

}