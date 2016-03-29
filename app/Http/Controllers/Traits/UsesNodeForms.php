<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\NodeSource;
use Reactor\Nodes\Node;
use Reactor\Nodes\NodeType;

trait UsesNodeForms {

    /**
     * @param int|null $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeForm($id)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\CreateNodeForm', [
            'url' => route('reactor.contents.store', $id)
        ]);
        $nodeTypes = NodeType::whereVisible(1)
            ->lists('label', 'id')
            ->toArray();
        $form->modify('type', 'select', [
            'choices' => $nodeTypes
        ]);

        if (locale_count() > 1)
        {
            $locales = [];
            foreach (config('translatable.locales') as $locale)
            {
                $locales[$locale] = trans('general.' . $locale);
            }
            $form->addAfter('type', 'locale', 'select', [
                'inline'   => true,
                'choices'  => $locales,
                'selected' => config('app.locale')
            ]);
        }
        
        return $form;
    }

    /**
     * @param int $id
     * @param Node $node
     * @param NodeSource $source
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeForm($id, Node $node, NodeSource $source)
    {
        $nodeType = $node->getNodeType()->name;
        $nodeTypeForm = 'gen\\Forms\\' . source_form_name($nodeType);

        $params = [
            'id'     => $id,
            'source' => $source->getKey()
        ];

        return $this->form($nodeTypeForm, [
            'url'   => route('reactor.contents.update', $params),
            // We do this because object_get method does not work for node sources
            // which FormBuilder uses to access attributes
            // Instead we prefer it to use array_get since toArray from Hierarchy
            // retrieves data properly.
            'model' => $source->toArray()
        ]);
    }

    /**
     * @param Request $request
     * @param Node $node
     * @param NodeSource $source
     */
    protected function validateUpdateNodeForm(Request $request, Node $node, NodeSource $source)
    {
        $this->validateForm(
            'gen\\Forms\\' . source_form_name($node->getNodeType()->name),
            $request, [
            'node_name' => 'max:255|alpha_dash|unique:node_sources,node_name,' . $source->getKey()
        ]);
    }

    /**
     * @param int $id
     * @param Node $node
     * @param int $sourceId
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeParametersForm($id, Node $node, $sourceId)
    {
        return $this->form('Reactor\Http\Forms\Nodes\EditNodeParametersForm', [
            'url'   => route('reactor.contents.parameters.update', [$id, $sourceId]),
            'model' => $node
        ]);
    }

    /**
     * @param int $id
     * @param NodeSource $source
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeSEOForm($id, NodeSource $source)
    {
        $params = [
            'id'     => $id,
            'source' => $source->getKey()
        ];

        return $this->form('Reactor\Http\Forms\Nodes\EditNodeSEOForm', [
            'url'   => route('reactor.contents.seo.update', $params),
            'model' => $source
        ]);
    }

    /**
     * @param Node $node
     * @param array $locales
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeTranslationForm(Node $node, array $locales)
    {
        $nodeType = $node->getNodeType()->name;
        $nodeTypeForm = 'gen\\Forms\\' . source_form_name($nodeType);

        $form = $this->form($nodeTypeForm, [
            'method' => 'post',
            'url'    => route('reactor.contents.translation.store', $node->getKey())
        ]);

        $form->addBefore('title', 'locale', 'select', [
            'choices' => $locales
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @param Node $node
     */
    protected function validateCreateNodeTranslationForm(Request $request, Node $node)
    {
        $this->validateForm(
            'gen\\Forms\\' . source_form_name($node->getNodeType()->name),
            $request);
    }

    /**
     * @param int $id
     * @param Node $node
     * @param int $sourceId
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getTransformNodeForm($id, Node $node, $sourceId)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\TransformNodeForm', [
            'url' => route('reactor.contents.transform.put', [$id, $sourceId])
        ]);

        $nodeTypes = NodeType::whereVisible(1)
            ->lists('label', 'id')
            ->toArray();

        unset($nodeTypes[$node->node_type_id]);

        $form->modify('type', 'select', [
            'choices' => $nodeTypes
        ]);

        return $form;
    }

}