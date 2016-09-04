<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Nuclear\Hierarchy\NodeType;

trait UsesMailingForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm()
    {
        $form = $this->form('Reactor\Html\Forms\Nodes\CreateForm', [
            'url' => route('reactor.mailings.store')
        ]);

        $form->modify('type', 'select', [
            'choices' => $this->compileAllowedNodeTypes()
        ]);

        $this->determineLocaleField($form);

        return $form;
    }

    /**
     * @return array
     */
    protected function compileAllowedNodeTypes()
    {
        return NodeType::whereVisible(1)
            ->forMailings()
            ->lists('label', 'id')
            ->toArray();
    }

    /**
     * @param Form $form
     */
    protected function determineLocaleField(Form $form)
    {
        if (locale_count() > 1)
        {
            $locales = [];

            foreach (locales() as $locale)
            {
                $locales[$locale] = trans('general.' . $locale);
            }

            $form->addAfter('type', 'locale', 'select', [
                'inline'   => true,
                'choices'  => $locales,
                'selected' => env('REACTOR_LOCALE')
            ]);
        }
    }

    /**
     * @param Request $request
     */
    protected function validateCreateForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Nodes\CreateForm', $request);
    }

}