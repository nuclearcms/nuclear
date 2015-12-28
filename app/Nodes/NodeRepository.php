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

    /**
     * Returns nodes by ids
     *
     * @param array|string $ids
     * @param bool $published
     * @return Collection
     */
    public function getNodesByIds($ids, $published = true)
    {
        if (empty($ids))
        {
            return null;
        }

        if (is_string($ids))
        {
            $ids = json_decode($ids, true);
        }

        if (is_array($ids) && !empty($ids))
        {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $nodes = Node::whereIn('id', $ids)
                ->orderByRaw('field(id,' . $placeholders . ')', $ids);

            if ($published)
            {
                $nodes->published();
            }

            $nodes = $nodes->get();

            return (count($nodes) > 0) ? $nodes : null;
        }

        return null;
    }

}