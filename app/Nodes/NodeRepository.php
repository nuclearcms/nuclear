<?php

namespace Reactor\Nodes;


class NodeRepository {

    /**
     * Returns the home node
     *
     * @param bool $track
     * @return Node
     */
    public function getHome($track = true)
    {
        $home = PublishedNode::whereHome(1)
            ->firstOrFail();

        $this->track($track, $home);

        return $home;
    }

    /**
     * Returns a node by name
     *
     * @param string $name
     * @param bool $track
     * @return Node
     */
    public function getNode($name, $track = true)
    {
        $node = PublishedNode::byName($name)
            ->firstOrFail();

        $this->track($track, $node);

        return $node;
    }

    /**
     * Returns a node by name and sets the locale
     *
     * @param string $name
     * @param bool $track
     * @return Node
     */
    public function getNodeAndSetLocale($name, $track = true)
    {
        $node = $this->getNode($name, $track);

        $locale = $node->getLocaleForNodeName($name);

        set_app_locale($locale);

        return $node;
    }

    /**
     * Searches for nodes
     *
     * @param string $keywords
     * @param int $limit
     * @param string $locale
     * @return Collection
     */
    public function searchNodes($keywords, $limit = null, $locale = null)
    {
        $results = PublishedNode::translatedIn($locale)
            ->search($keywords)
            ->distinct();

        if ( ! is_null($limit))
        {
            $results->limit($limit);
        }

        return $results->get();
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

        if (is_array($ids) && ! empty($ids))
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

    /**
     * Tracks the node
     *
     * @param $track
     * @param $node
     */
    protected function track($track, $node)
    {
        if ($track)
        {
            tracker()->addTrackable($node);
        }
    }

}