<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Nuclear\Hierarchy\Node;
use Nuclear\Hierarchy\NodeSource;
use Nuclear\Hierarchy\NodeType;

trait UsesNodeForms {

    /**
     * @param int|null $id
     * @param Node $parent
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm($id, Node $parent = null)
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

    /**
     * @param int|null $id
     * @param Node $node
     * @param NodeSource $source
     * @return Form
     */
    protected function getEditForm($id, Node $node, NodeSource $source)
    {
        $form = $this->form(
            source_form_name($node->getNodeTypeName(), true), [
            'url'   => route('reactor.nodes.update', [$id, $source->getKey()]),
            'model' => $source->toArray()
        ]);

        $form->compose('Reactor\Html\Forms\Nodes\EditSEOForm');

        $form->exclude(['meta_title', 'meta_keywords', 'meta_description',
            'meta_image', 'meta_author']);

        return $form;
    }

    /**
     * @param Request $request
     * @param Node $node
     * @param NodeSource $source
     */
    protected function validateEditForm(Request $request, Node $node, NodeSource $source)
    {
        $this->validateForm(
            source_form_name($node->getNodeTypeName(), true),
            $request, [
            'node_name' => 'max:255|alpha_dash|unique:node_sources,node_name,' . $source->getKey()
        ]);
    }

    /**
     * @param int $id
     * @param Node $node
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditParametersForm($id, Node $node)
    {
        return $this->form('Reactor\Html\Forms\Nodes\EditParametersForm', [
            'url'   => route('reactor.nodes.parameters.update', $id),
            'model' => $node
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateEditParametersForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Nodes\EditParametersForm', $request);
    }

    /**
     * @param int $id
     * @param array $locales
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateTranslationForm($id, array $locales)
    {
        $form = $this->form('Nuclear\Hierarchy\Http\Forms\NodeSourceForm', [
            'url' => route('reactor.nodes.translation.store', $id),
            'method' => 'POST'
        ]);

        $form->addBefore('title', 'locale', 'select', [
            'choices' => $locales,
            'inline' => true
        ]);

        return $form;
    }

    /**
     * @param Request $request
     */
    protected function validateCreateTranslationForm(Request $request)
    {
        $this->validateForm('Nuclear\Hierarchy\Http\Forms\NodeSourceForm', $request);
    }

    /**
     * @param int $id
     * @param Node $node
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getTransformForm($id, Node $node)
    {
        $form = $this->form('Reactor\Html\Forms\Nodes\TransformForm', [
            'url' => route('reactor.nodes.transform.put', $id)
        ]);

        $nodeTypes = $this->compileAllowedNodeTypes($node->parent);
        unset($nodeTypes[$node->node_type_id]);

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

    /**
     * @param int $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getMoveForm($id)
    {
        return $this->form('Reactor\Html\Forms\Nodes\MoveForm', [
            'url'   => route('reactor.nodes.move.put', $id),
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateMoveForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Nodes\MoveForm', $request);
    }

}