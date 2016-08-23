<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Nuclear\Hierarchy\Node;
use Nuclear\Hierarchy\NodeType;

trait UsesNodeForms {

    /**
     * @param int|null $id
     * @param Node $parent
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm($id, $parent)
    {
        $form = $this->form('Reactor\Html\Forms\Nodes\CreateForm', [
            'url' => route('reactor.nodes.store', $id)
        ]);

        $form->modify('type', 'select', [
            'choices' => $this->compileAllowedNodeTypes($parent)
        ]);

        $this->determineLocaleField($form);

        return $form;
    }

    /**
     * @param Node $parent
     * @return array
     */
    protected function compileAllowedNodeTypes(Node $parent = null)
    {
        $nodeTypes = NodeType::whereVisible(1)
            ->forNodes()
            ->lists('label', 'id')
            ->toArray();

        if ($parent)
        {
            $allowed = json_decode($parent->getNodeType()->allowed_children);

            if(count($allowed))
            {
                foreach ($nodeTypes as $key => $value)
                {
                    if ( ! in_array($key, $allowed))
                    {
                        unset($nodeTypes[$key]);
                    }
                }
            }
        }

        return $nodeTypes;
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