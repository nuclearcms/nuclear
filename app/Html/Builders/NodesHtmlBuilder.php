<?php


namespace Reactor\Html\Builders;


use Illuminate\Database\Eloquent\Collection;
use Nuclear\Hierarchy\Node;

class NodesHtmlBuilder {

    /**
     * Makes an array of ancestor links
     *
     * @param Collection $ancestors
     * @return array
     */
    public function ancestorLinks(Collection $ancestors)
    {
        $links = [];

        foreach ($ancestors as $ancestor)
        {
            $links[] = link_to($ancestor->getDefaultEditUrl(), $ancestor->getTitle());
        }

        return $links;
    }

    /**
     * Snippet for displaying node default content options
     *
     * @param Node $node
     * @param string $header
     * @param bool $table
     * @return string
     */
    public function nodeOptions(Node $node, $header = null, $table = true)
    {
        $id = $node->getKey();
        $sourceId = $node->translateOrFirst()->getKey();

        $html = '';

        if ($node->canHaveChildren())
        {
            $html .= '<li class="dropdown-sub__item">
                <a href="' . route('reactor.nodes.create', $id) . '">
                    <i class="icon-plus"></i>' . trans('nodes.add_child') . '</a>
            </li>
            <li class="dropdown-sub__splitter"></li>';
        }

        $html .= '<li class="dropdown-sub__item">
            <a href="' . route('reactor.nodes.edit', [$id, $sourceId]) . '">
                <i class="icon-pencil"></i>' . trans('nodes.edit') . '</a>
        </li>';

        if ($node->canHaveMoreTranslations())
        {
            $html .= '<li class="dropdown-sub__item">
                <a href="' . route('reactor.nodes.translation.create', [$id, $sourceId]) . '">
                    <i class="icon-language"></i>' . trans('general.add_translation') . '</a>
            </li>';
        }

        $html .= '<li class="dropdown-sub__item dropdown-sub__item--delete">' .
            delete_form(
                route('reactor.nodes.destroy', $id),
                trans('nodes.destroy')) .
            '</li>
        <li class="dropdown-sub__splitter"></li>
        <li class="dropdown-sub__item">' . $this->nodeOptionForm(
            $node->isPublished() ? route('reactor.nodes.unpublish', $id) : route('reactor.nodes.publish', $id),
            $node->isPublished() ? 'icon-status-withheld' : 'icon-status-published',
            $node->isPublished() ? 'nodes.unpublish' : 'nodes.publish'
        ) . '</li>
        <li class="dropdown-sub__item">' . $this->nodeOptionForm(
            $node->isLocked() ? route('reactor.nodes.unlock', $id) : route('reactor.nodes.lock', $id),
            $node->isLocked() ? 'icon-blank' : 'icon-status-locked',
            $node->isLocked() ? 'nodes.unlock' : 'nodes.lock'
        ) . '</li>';

        return content_options_open($header, $table) . $html . content_options_close($table);
    }

    /**
     * Snippet for displaying node default content options
     *
     * @param Node $node
     * @return string
     */
    public function treeNodeOptions(Node $node)
    {
        return $this->nodeOptions($node,
        '<div class="dropdown__info navigation-module__info" style="background-color:' . $node->getNodeType()->color . ';">'
            . uppercase($node->getNodeType()->label) .
        '</div>', false);
    }

    /**
     * Snippet for displaying node option forms
     *
     * @param string $action
     * @param string $icon
     * @param string $text
     * @return string
     */
    function nodeOptionForm($action, $icon, $text)
    {
        return sprintf('<form action="%s" method="POST">' .
            method_field('PUT') . csrf_field() .
            '<button type="submit">
                <i class="%s"></i>%s
            </button></form>',
            $action, $icon, trans($text)
        );
    }

}