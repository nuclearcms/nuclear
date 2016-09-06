<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Nuclear\Hierarchy\MailingNode;
use Nuclear\Hierarchy\NodeSource;
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

    /**
     * @param int|null $id
     * @param NodeSource $source
     * @return Form
     */
    protected function getEditForm($id, NodeSource $source)
    {
        return $this->form(
            source_form_name($source->source_type, true), [
            'url'   => route('reactor.mailings.update', $id),
            'model' => $source->toArray()
        ]);
    }

    /**
     * @param Request $request
     * @param NodeSource $source
     */
    protected function validateEditForm(Request $request, NodeSource $source)
    {
        $this->validateForm(
            source_form_name($source->source_type, true),
            $request, [
            'node_name' => 'max:255|alpha_dash|unique:node_sources,node_name,' . $source->getKey()
        ]);
    }

    /**
     * @param int $id
     * @param MailingNode $mailing
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getTransformForm($id, MailingNode $mailing)
    {
        $form = $this->form('Reactor\Html\Forms\Nodes\TransformForm', [
            'url' => route('reactor.mailings.transform.put', $id)
        ]);

        $nodeTypes = $this->compileAllowedNodeTypes();
        unset($nodeTypes[$mailing->node_type_id]);

        $form->modify('type', 'select', [
            'choices' => $nodeTypes
        ]);

        return $form;
    }

    /**
     * @param Request $request
     */
    protected function validateTransformForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Nodes\TransformForm', $request);
    }

}