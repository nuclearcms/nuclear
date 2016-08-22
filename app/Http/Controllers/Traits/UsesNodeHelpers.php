<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\Node;

trait UsesNodeHelpers {

    /**
     * Validates if the parent can have children nodes
     *
     * @param Node $parent
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function validateParentCanHaveChildren(Node $parent = null)
    {
        if ($parent && $parent->sterile)
        {
            abort(500, 'Node is sterile.');
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return static
     */
    protected function createNode(Request $request, $id)
    {
        $node = new Node;

        $node->setNodeTypeByKey($request->input('type'));

        $locale = $this->validateLocale($request, true);

        $node->fill([
            $locale => $request->all()
        ]);

        $node = $this->locateNodeInTree($id, $node);

        $node->save();

        return [$node, $locale];
    }

    /**
     * @param int $id
     * @param Node $node
     * @return mixed
     */
    protected function locateNodeInTree($id, Node $node)
    {
        if (is_null($id))
        {
            return $node->makeRoot();
        }

        $parent = Node::findOrFail($id);
        $node->appendToNode($parent);

        return $node;
    }

}