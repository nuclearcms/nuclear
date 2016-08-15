<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\Tags\Tag;
use Nuclear\Hierarchy\Tags\TagTranslation;

trait UsesTagForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm()
    {
        return $this->form('Reactor\Html\Forms\Tags\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.tags.store')
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateCreateForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Tags\CreateEditForm', $request);
    }

    /**
     * @param int $id
     * @param TagTranslation $translation
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditForm($id, TagTranslation $translation)
    {
        return $this->form('Reactor\Html\Forms\Tags\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.tags.update', [$id, $translation->getKey()]),
            'model'  => $translation
        ]);
    }

    /**
     * @param Request $request
     * @param TagTranslation $translation
     */
    protected function validateEditForm(Request $request, TagTranslation $translation)
    {
        $this->validateForm('Reactor\Html\Forms\Tags\CreateEditForm', $request, [
            'title' => ['required', 'max:255',
                'unique:tag_translations,title,' . $translation->getKey()],
            'tag_name' => ['max:255', 'alpha_dash',
                'unique:tag_translations,tag_name,' . $translation->getKey()]
        ]);
    }

    /**
     * @param Tag $tag
     * @param array $locales
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateTranslationForm(Tag $tag, array $locales)
    {
        $form = $this->form('Reactor\Html\Forms\Tags\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.tags.translations.store', [$tag->getKey()])
        ]);

        $form->addBefore('title', 'locale', 'select', [
            'choices' => $locales
        ]);

        return $form;
    }

}