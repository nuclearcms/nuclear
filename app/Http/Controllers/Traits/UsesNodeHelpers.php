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

    /**
     * @param int $id
     * @param int $source
     * @param string $permission
     * @param bool $withSource
     * @return array
     */
    protected function authorizeAndFindNode($id, $source, $permission = null, $withSource = true)
    {
        if ( ! is_null($permission))
        {
            $this->authorize($permission);
        }


        $node = Node::findOrFail($id);

        if ( ! $withSource)
        {
            return $node;
        }

        list($locale, $source) = $this->determineLocaleAndSource($source, $node);

        return [$node, $locale, $source];
    }

    /**
     * Determines the current editing locale
     *
     * @param int|null $source
     * @param Node $node
     * @return string
     */
    protected function determineLocaleAndSource($source, Node $node)
    {
        if ($source)
        {
            $source = $node->translations->find($source);

            if (is_null($source))
            {
                abort(404);
            }
        } else
        {
            $source = $node->translate();

            if (is_null($source))
            {
                $source = $node->translations->first();
            }
        }

        return [$source->locale, $source];
    }

    /**
     * Determines the node publishing
     *
     * @param Request $request
     * @param Node $node
     */
    protected function determinePublish(Request $request, Node $node)
    {
        if ($request->get('_publish') === 'publish')
        {
            $node->publish();
        }
    }

    /**
     * @param Request $request
     * @param int $id
     */
    protected function determineHomeNode(Request $request, $id)
    {
        if ($request->input('home') === '1')
        {
            $home = Node::whereHome(1)->where('id', '<>', $id)->first();

            if ($home)
            {
                $home->update(['home' => 0]);
            }
        }
    }

    /**
     * Checks if the node is locked
     * if so notifies and returns a response
     *
     * @param Node $node
     * @return response
     */
    protected function validateNodeIsNotLocked(Node $node)
    {
        if ($node->isLocked())
        {
            $this->notify('nodes.node_is_locked', null, null, 'error');

            return redirect()->back();
        }

        return false;
    }

    /**
     * Changes the status of the node
     *
     * @param int $id
     * @param string $status
     * @param string $message
     * @return redirect
     */
    protected function changeNodeStatus($id, $status, $message)
    {
        $node = $this->authorizeAndFindNode($id, null, 'EDIT_NODES', false);

        $node->{$status}()->save();

        $this->notify('nodes.' . $message . '_node');

        return redirect()->back();
    }

    /**
     * Attaches or detaches a tag
     *
     * @param Request $request
     * @param int $id
     * @param string $mode
     * @return response
     */
    protected function attachOrDetachTag(Request $request, $id, $mode)
    {
        $node = $this->authorizeAndFindNode($id, null, 'EDIT_NODES', false);

        if ($node->isLocked())
        {
            return response()->json([
                'type'    => 'danger',
                'message' => trans('nodes.node_is_locked')
            ]);
        }

        $node->{$mode . 'Tag'}($request->input('tagid'));

        return response()->json(['type' => 'success']);
    }

}