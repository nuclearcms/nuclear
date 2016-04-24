<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;

class PreviewController extends ReactorController {
    
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
    
}