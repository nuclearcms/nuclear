<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\UsesNodeHelpers;

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

        if (empty($node->nodeType->preview_template))
        {
            abort(500, 'Preview template for this node type is not defined.');
        }

        \Theme::set(config('themes.active_preview'));

        return view($node->nodeType->preview_template, compact('node', 'locale', 'source'));
    }

}