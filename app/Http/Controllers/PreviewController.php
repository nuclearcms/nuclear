<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\UsesNodeHelpers;
use Reactor\Nodes\RouteMaker;
use Reactor\Support\TokenManager;

class PreviewController extends ReactorController {

    use UsesNodeHelpers;

    /**
     * Generates preview for any markdown field
     *
     * @param Request $request
     * @return Response
     */
    public function getMarkdownPreview(Request $request)
    {
        $text = $request->input('text');

        return response()->json(
            \Synthesizer::HTMLmarkdown($text)
        );
    }

    /**
     * Shows preview for a node
     *
     * @param int $node
     * @param int $source
     * @return View
     */
    public function getNodePreview($node, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($node, $source, 'ACCESS_CONTENTS');

        if ( ! $node->getNodeType()->hasPreviewTemplate())
        {
            abort(500, 'Preview template for this node type is not defined.');
        }

        set_app_locale($locale);

        \Theme::set(config('themes.active_preview'));

        return view($node->getNodeType()->preview_template, compact('node', 'locale', 'source'));
    }

    /**
     * Redirects to preview on site
     *
     * @param TokenManager $tokenManager
     * @param int $node
     * @param int $source
     * @return Redirect
     */
    public function getNodeSitePreview(TokenManager $tokenManager, $node, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($node, $source, 'ACCESS_CONTENTS');

        if ( ! $node->getNodeType()->hasRouteTemplate())
        {
            abort(500, 'Route template for this node type is not defined.');
        }

        set_app_locale($locale);

        $token = $tokenManager->makeNewToken('preview_nodes');

        $url = (new RouteMaker($node->getNodeType()->route_template, $node))
            ->makeRouteURL(['preview_nodes' => $token]);

        return redirect($url);
    }

}