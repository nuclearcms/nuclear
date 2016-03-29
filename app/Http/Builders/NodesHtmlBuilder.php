<?php

namespace Reactor\Http\Builders;


use Illuminate\Support\Collection;
use Reactor\Nodes\Node;

class NodesHtmlBuilder {

    /**
     * @var FormsHtmlBuilder
     */
    protected $formsHtmlBuilder;

    /**
     * @var ContentsHtmlBuilder
     */
    protected $contentsHtmlBuilder;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formsHtmlBuilder = app('reactor.builders.forms');
        $this->contentsHtmlBuilder = app('reactor.builders.contents');
    }

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
            $links[] = link_to($ancestor->getDefaultLink(), $ancestor->title);
        }

        return $links;
    }

    /**
     * Snippet for generating node options
     *
     * @param Node $node
     * @return string
     */
    function nodeOptionsList(Node $node)
    {
        $list = '<div class="node-options">' . $this->contentsHtmlBuilder->contentOptionsOpen(
                '<li class="options-header" style="background-color:' . $node->getNodeType()->color . ';">'
                . uppercase($node->getNodeType()->label) .
                '</li>', false
            );

        if ($node->canHaveChildren())
        {
            $list .= '<li>
                <a href="' . route('reactor.contents.create', $node->getKey()) . '">
                    <i class="icon-plus"></i> ' . trans('nodes.add_child') . '</a>
            </li>';
        }

        $list .= '<li>
            <a href="' . route('reactor.contents.edit', $node->getKey()) . '">
                <i class="icon-pencil"></i> ' . trans('nodes.edit') . '</a>
        </li><li>' . $this->formsHtmlBuilder->deleteForm(
                route('reactor.contents.destroy', $node->getKey()),
                trans('nodes.delete')
            ) . '</li><li class="options-splitter"></li><li>' . $this->nodeOptionForm(
                $node->isPublished() ? route('reactor.contents.unpublish', $node->getKey()) : route('reactor.contents.publish', $node->getKey()),
                $node->isPublished() ? 'icon-cancel-circled' : 'icon-publish',
                $node->isPublished() ? 'nodes.unpublish' : 'nodes.publish'
            ) . '</li>' . $this->contentsHtmlBuilder->contentOptionsClose(false) . '</div>';

        return $list;
    }

    /**
     * Snippet for for outputting html for delete forms
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
            '<button type="submit" class="option-general">
                <i class="%s"></i> %s
            </button></form>',
            $action,
            $icon,
            trans($text)
        );
    }

}