<?php

namespace Reactor\Nodes;


class NodeRepository {

    /**
     * Returns the home node
     *
     * @return Node
     */
    public function getHome()
    {
        return Node::published()
            ->whereHome(1)
            ->firstOrFail();
    }

    /**
     * Returns a node by name
     *
     * @param string $name
     * @return Node
     */
    public function getNode($name)
    {
        return Node::whereTranslation('node_name', $name)
            ->published()
            ->firstOrFail();
    }

    /**
     * Returns a node by name and sets the locale
     *
     * @param $name
     * @return Node
     */
    public function getNodeAndSetLocale($name)
    {
        $node = $this->getNode($name);

        $locale = $node->getLocaleForNodeName($name);

        app()->setLocale($locale);

        return $node;
    }

}